let janus = null;
let pluginHandler = null;
const opaqueId = "videoroomtest-" + Janus.randomString(12);
const server = "wss://" + window.location.hostname + ":8989/ws";

let doSimulcast = (getQueryStringValue("simulcast") === "yes" || getQueryStringValue("simulcast") === "true");
let doSimulcast2 = (getQueryStringValue("simulcast2") === "yes" || getQueryStringValue("simulcast2") === "true");
let acodec = (getQueryStringValue("acodec") !== "" ? getQueryStringValue("acodec") : null);
let vcodec = (getQueryStringValue("vcodec") !== "" ? getQueryStringValue("vcodec") : null);
let subscriber_mode = (getQueryStringValue("subscriber-mode") === "yes" || getQueryStringValue("subscriber-mode") === "true");

let myStream = null;
let feeds = [];
let bitrateTimer = [];

const handleMQTTPaho = () => {
	const wsbroker = "localhost"; // mqtt websocket enabled broker
	const wsport = 15675; // port for above
	const client = new Paho.MQTT.Client(
		wsbroker,
		wsport,
		"/ws",
		"myclientid_" + parseInt(Math.random() * 100, 10)
	);

	connect();

	client.onConnectionLost = function (responseObject) {
		console.log("Connection Lost: " + responseObject.errorMessage);
		connect();
	};

	client.onMessageArrived = function (message) {
		const objData = JSON.parse(message.payloadString);

		$.pjax.reload({ container: "#room-button", async: false });
		$.pjax.reload({ container: "#room-request", async: false });
		$.pjax.reload({ container: "#room-member", async: false });

		// if (objData.type === "request_join") {
		if (is_owner) {
			$.pjax.reload({ container: "#room-video" });
		}
		// }

		if (objData.type === "response_join") {
			if (Number(objData.user_id) === Number(user_id) && !is_owner) {
				window.location.reload();
			}
		}
	};

	function connect() {
		client.connect({
			// timeout: 3,
			// keepAliveInterval: 30,
			// useSSL: true,
			// cleanSession : false,
			onSuccess: () => {
				client.subscribe(window.location.pathname);
				console.log("Connected!");
			},
		});
	}
};
const compLocal = $("#videolocal");

const initJanus = () => {
	Janus.init({
		debug: "all",
		callback: function () {
			janus = new Janus({
				token: mytoken,
				server: server,
				success: function () {
					// Attach to VideoRoom plugin
					janus.attach({
						plugin: "janus.plugin.videoroom",
						opaqueId: opaqueId,
						success: function (pluginHandle) {
							pluginHandler = pluginHandle;
							//   $('#videojoin').removeClass('hide').show();
							joinMe()
						},
						error: function (error) {
							Janus.error("  -- Error attaching plugin...", error);
							bootbox.alert("Error attaching plugin... " + error);
						},
						consentDialog: function (on) {
							Janus.debug(
								"Consent dialog should be " + (on ? "on" : "off") + " now"
							);
							if (on) {
								// Darken screen and show hint
								$.blockUI({
									message: '<div><img src="up_arrow.png"/></div>',
									css: {
										border: 'none',
										padding: '15px',
										backgroundColor: 'transparent',
										color: '#aaa',
										top: '10px',
										left: (navigator.mozGetUserMedia ? '-100px' : '300px')
									}
								});
							} else {
								// Restore screen
								$.unblockUI();
							}
						},
						iceState: function (state) {
							Janus.log("ICE state changed to " + state);
						},
						mediaState: function (medium, on) {
							Janus.log(
								"Janus " +
								(on ? "started" : "stopped") +
								" receiving our " +
								medium
							);
						},
						webrtcState: function (on) {
							Janus.log(
								"Janus says our WebRTC PeerConnection is " +
								(on ? "up" : "down") +
								" now"
							);
							compLocal.parent().parent().unblock();
							if (!on) return;
							$('#publish').remove();
							// This controls allows us to override the global room bitrate cap
							//   $('#bitrate').parent().parent().removeClass('hide').show();
							//   $('#bitrate a').click(function() {
							//   	var id = $(this).attr("id");
							//   	var bitrate = parseInt(id)*1000;
							//   	if(bitrate === 0) {
							//   		Janus.log("Not limiting bandwidth via REMB");
							//   	} else {
							//   		Janus.log("Capping bandwidth to " + bitrate + " via REMB");
							//   	}
							//   	$('#bitrateset').html($(this).html() + '<span class="caret"></span>').parent().removeClass('open');
							//   	sfutest.send({ message: { request: "configure", bitrate: bitrate }});
							//   	return false;
							//   });
						},
						onmessage: function (msg, jsep) {
							Janus.debug(" ::: Got a message (publisher) :::", msg);
							const event = msg["videoroom"];
							if (event) {
								if (event === "joined") {
									// Publisher/manager created, negotiate WebRTC and attach to existing feeds, if any
									myid = msg["id"];
									mypvtid = msg["private_id"];
									Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
									if (subscriber_mode) {
										$('#videojoin').hide();
										$('#videos').removeClass('hide').show();
									} else {
										publishOwnFeed(true);
									}
									// Any new feed to attach to?
									if (msg["publishers"]) {
										var list = msg["publishers"];
										Janus.debug("Got a list of available publishers/feeds:", list);
										for (var f in list) {
											var id = list[f]["id"];
											var display = list[f]["display"];
											var audio = list[f]["audio_codec"];
											var video = list[f]["video_codec"];
											Janus.debug("  >> [" + id + "] " + display + " (audio: " + audio + ", video: " + video + ")");
											newRemoteFeed(id, display, audio, video);
										}
									}
								} else if (event === "destroyed") {
									// The room has been destroyed
									Janus.warn("The room has been destroyed!");
									bootbox.alert("The room has been destroyed", function () {
										window.location.reload();
									});
								} else if (event === "event") {
									// Any new feed to attach to?
									if (msg["publishers"]) {
										const list = msg["publishers"];
										Janus.debug("Got a list of available publishers/feeds:", list);
										for (let f in list) {
											const id = list[f]["id"];
											const display = list[f]["display"];
											const audio = list[f]["audio_codec"];
											const video = list[f]["video_codec"];
											Janus.debug("  >> [" + id + "] " + display + " (audio: " + audio + ", video: " + video + ")");
											newRemoteFeed(id, display, audio, video);
										}
									} else if (msg["leaving"]) {
										console.log("leavinggggggggggggggggggggggggggg")
										// One of the publishers has gone away?
										var leaving = msg["leaving"];
										Janus.log("Publisher left: " + leaving);
										var remoteFeed = null;
										for (var i = 1; i < 6; i++) {
											if (feeds[i] && feeds[i].rfid == leaving) {
												remoteFeed = feeds[i];
												break;
											}
										}
										if (remoteFeed != null) {
											Janus.debug("Feed " + remoteFeed.rfid + " (" + remoteFeed.rfdisplay + ") has left the room, detaching");
											$('#remote' + remoteFeed.rfindex).empty().hide();
											$('#videoremote' + remoteFeed.rfindex).empty();
											feeds[remoteFeed.rfindex] = null;
											remoteFeed.detach();
										}
									} else if (msg["unpublished"]) {
										// One of the publishers has unpublished?
										var unpublished = msg["unpublished"];
										Janus.log("Publisher left: " + unpublished);
										if (unpublished === 'ok') {
											// That's us
											pluginHandler.hangup();
											return;
										}
										var remoteFeed = null;
										for (var i = 1; i < 6; i++) {
											if (feeds[i] && feeds[i].rfid == unpublished) {
												remoteFeed = feeds[i];
												break;
											}
										}
										if (remoteFeed != null) {
											Janus.debug("Feed " + remoteFeed.rfid + " (" + remoteFeed.rfdisplay + ") has left the room, detaching");
											$('#remote' + remoteFeed.rfindex).empty().hide();
											$('#videoremote' + remoteFeed.rfindex).empty();
											feeds[remoteFeed.rfindex] = null;
											remoteFeed.detach();
										}
									} else if (msg["error"]) {
										if (msg["error_code"] === 426) {
											// This is a "no such room" error: give a more meaningful description
											bootbox.alert(
												"<p>Apparently room <code>" + myroom + "</code> (the one this demo uses as a test room) " +
												"does not exist...</p><p>Do you have an updated <code>janus.plugin.videoroom.jcfg</code> " +
												"configuration file? If not, make sure you copy the details of room <code>" + myroom + "</code> " +
												"from that sample in your current configuration file, then restart Janus and try again."
											);
										} else {
											bootbox.alert(msg["error"]);
										}
									}
								}
							}
							if (jsep) {
								Janus.debug("Handling SDP as well...", jsep);
								pluginHandler.handleRemoteJsep({ jsep });
								// Check if any of the media we wanted to publish has
								// been rejected (e.g., wrong or unsupported codec)
								const audio = msg["audio_codec"];
								if (myStream && myStream.getAudioTracks() && myStream.getAudioTracks().length > 0 && !audio) {
									// Audio has been rejected
									toastr.warning("Our audio stream has been rejected, viewers won't hear us");
								}
								const video = msg["video_codec"];
								if (myStream && myStream.getVideoTracks() && myStream.getVideoTracks().length > 0 && !video) {
									// Video has been rejected
									toastr.warning("Our video stream has been rejected, viewers won't see us");
									// Hide the webcam video
									$('#myvideo').hide();
									compLocal.append(
										'<div class="no-video-container">' +
										'<i class="fa fa-video-camera fa-5 no-video-icon" style="height: 100%;"></i>' +
										'<span class="no-video-text" style="font-size: 16px;">Video rejected, no webcam</span>' +
										'</div>');
								}
							}
						},
						onlocalstream: function (stream) {
							Janus.debug(" ::: Got a local stream :::", stream);
							myStream = stream;
							// $('#videojoin').hide();
							// $('#videos').removeClass('hide').show();
							if ($('#myvideo').length === 0) {
								compLocal.append('<video class="rounded centered" id="myvideo" width="100%" height="100%" autoplay playsinline muted="muted"/>');
								// Add a 'mute' button
								compLocal.append('<button class="btn btn-warning btn-xs" id="mute" style="position: absolute; bottom: 0px; left: 0px; margin: 15px;">Mute</button>');
								$('#mute').click(toggleMute);
								// Add an 'unpublish' button
								compLocal.append('<button class="btn btn-warning btn-xs" id="unpublish" style="position: absolute; bottom: 0px; right: 0px; margin: 15px;">Unpublish</button>');
								$('#unpublish').click(unpublishOwnFeed);
							}
							// $('#publisher').removeClass('hide').html(myusername).show();
							Janus.attachMediaStream($('#myvideo').get(0), stream);
							$("#myvideo").get(0).muted = "muted";
							if (pluginHandler.webrtcStuff.pc.iceConnectionState !== "completed" &&
								pluginHandler.webrtcStuff.pc.iceConnectionState !== "connected") {
								compLocal.parent().parent().block({
									message: '<b>Publishing...</b>',
									css: {
										border: 'none',
										backgroundColor: 'transparent',
										color: 'white'
									}
								});
							}
							const videoTracks = stream.getVideoTracks();
							if (!videoTracks || videoTracks.length === 0) {
								// No webcam
								$('#myvideo').hide();
								if ($('#videolocal .no-video-container').length === 0) {
									compLocal.append(
										'<div class="no-video-container">' +
										'<i class="fa fa-video-camera fa-5 no-video-icon"></i>' +
										'<span class="no-video-text">No webcam available</span>' +
										'</div>');
								}
							} else {
								$('#videolocal .no-video-container').remove();
								$('#myvideo').removeClass('hide').show();
							}
						},
						onremotestream: function (stream) {
							// The publisher stream is sendonly, we don't expect anything here
						},
						oncleanup: function () {
							Janus.log(
								" ::: Got a cleanup notification: we are unpublished now :::"
							);
							myStream = null;
							compLocal.html('<button id="publish" class="btn btn-primary">Publish</button>');
							$('#publish').click(function () { publishOwnFeed(true); });
							compLocal.parent().parent().unblock();
							//   $('#bitrate').parent().parent().addClass('hide');
							//   $('#bitrate a').unbind('click');
						},
					});
				},
				error: function (error) {
					Janus.error(error);
					bootbox.alert(error, function () {
						window.location.reload();
					});
				},
				destroyed: function () {
					window.location.reload();
				},
			});
		},
	});
};


$(document).ready(function () {
	handleMQTTPaho();
	if (!Janus.isWebrtcSupported()) {
		bootbox.alert("No WebRTC support... ");
		return;
	}
	if (is_owner || is_allowed) {
		$.pjax.reload({ container: "#room-button", async: false });
		$.pjax.reload({ container: "#room-request", async: false });
		$.pjax.reload({ container: "#room-member", async: false });
		initJanus()
	}
});

$(document).on("click", "#btnJoin", function (e) {
	joinHandler("request", user_id);
});

$(document).on("click", "#btnAllow", function (e) {
	joinHandler("allow", $(this).data("user"));
});

$(document).on("click", "#btnDeny", function (e) {
	joinHandler("deny", $(this).data("user"));
});

function joinHandler(action, user_id) {
	$.post({
		url: "/room/join/" + action,
		data: { uuid: myroom, user_id },
		cache: false,
	});
}
