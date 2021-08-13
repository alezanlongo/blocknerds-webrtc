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

	$.pjax.reload({ container: "#room-button", async:false });
	$.pjax.reload({ container: "#room-request", async:false });
	$.pjax.reload({ container: "#room-member", async:false });

    // if (objData.type === "request_join") {
		if(is_owner){
			$.pjax.reload({ container: "#room-video"});
		}
    // }
	
	if (objData.type === "response_join") {
		if(Number(objData.user_id) === Number(user_id)  && !is_owner){
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
const compLocal = $("#video-source" + user_id);

const initJanus = () => {
  Janus.init({
    debug: "all",
    callback: function () {
      janus = new Janus({
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
              if(on) {
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
              		} });
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
              if(!on) return;
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
              if(event) {
              	if(event === "joined") {
              		// Publisher/manager created, negotiate WebRTC and attach to existing feeds, if any
              		myid = msg["id"];
              		mypvtid = msg["private_id"];
              		Janus.log("Successfully joined room " + msg["room"] + " with ID " + myid);
              		if(subscriber_mode) {
              			$('#videojoin').hide();
              			$('#videos').removeClass('hide').show();
              		} else {
              			publishOwnFeed(true);
              		}
              		// Any new feed to attach to?
              		if(msg["publishers"]) {
              			var list = msg["publishers"];
              			Janus.debug("Got a list of available publishers/feeds:", list);
              			for(var f in list) {
              				var id = list[f]["id"];
              				var display = list[f]["display"];
              				var audio = list[f]["audio_codec"];
              				var video = list[f]["video_codec"];
              				Janus.debug("  >> [" + id + "] " + display + " (audio: " + audio + ", video: " + video + ")");
              				newRemoteFeed(id, display, audio, video);
              			}
              		}
              	} else if(event === "destroyed") {
              		// The room has been destroyed
              		Janus.warn("The room has been destroyed!");
              		bootbox.alert("The room has been destroyed", function() {
              			window.location.reload();
              		});
              	} else if(event === "event") {
              		// Any new feed to attach to?
              		if(msg["publishers"]) {
              			const list = msg["publishers"];
              			Janus.debug("Got a list of available publishers/feeds:", list);
              			for(let f in list) {
              				const id = list[f]["id"];
              				const display = list[f]["display"];
              				const audio = list[f]["audio_codec"];
              				const video = list[f]["video_codec"];
              				Janus.debug("  >> [" + id + "] " + display + " (audio: " + audio + ", video: " + video + ")");
              				newRemoteFeed(id, display, audio, video);
              			}
              		} else if(msg["leaving"]) {
						console.log("leavinggggggggggggggggggggggggggg")
              			// One of the publishers has gone away?
              			var leaving = msg["leaving"];
              			Janus.log("Publisher left: " + leaving);
              			var remoteFeed = null;
              			for(var i=1; i<6; i++) {
              				if(feeds[i] && feeds[i].rfid == leaving) {
              					remoteFeed = feeds[i];
              					break;
              				}
              			}
              			if(remoteFeed != null) {
              				Janus.debug("Feed " + remoteFeed.rfid + " (" + remoteFeed.rfdisplay + ") has left the room, detaching");
              				$('#remote'+remoteFeed.rfindex).empty().hide();
              				$('#videoremote'+remoteFeed.rfindex).empty();
              				feeds[remoteFeed.rfindex] = null;
              				remoteFeed.detach();
              			}
              		} else if(msg["unpublished"]) {
              			// One of the publishers has unpublished?
              			var unpublished = msg["unpublished"];
              			Janus.log("Publisher left: " + unpublished);
              			if(unpublished === 'ok') {
              				// That's us
              				pluginHandler.hangup();
              				return;
              			}
              			var remoteFeed = null;
              			for(var i=1; i<6; i++) {
              				if(feeds[i] && feeds[i].rfid == unpublished) {
              					remoteFeed = feeds[i];
              					break;
              				}
              			}
              			if(remoteFeed != null) {
              				Janus.debug("Feed " + remoteFeed.rfid + " (" + remoteFeed.rfdisplay + ") has left the room, detaching");
              				$('#remote'+remoteFeed.rfindex).empty().hide();
              				$('#videoremote'+remoteFeed.rfindex).empty();
              				feeds[remoteFeed.rfindex] = null;
              				remoteFeed.detach();
              			}
              		} else if(msg["error"]) {
              			if(msg["error_code"] === 426) {
              				// This is a "no such room" error: give a more meaningful description
              				bootbox.alert(
              					"<p>Apparently room <code>" + room_uuid + "</code> (the one this demo uses as a test room) " +
              					"does not exist...</p><p>Do you have an updated <code>janus.plugin.videoroom.jcfg</code> " +
              					"configuration file? If not, make sure you copy the details of room <code>" + room_uuid + "</code> " +
              					"from that sample in your current configuration file, then restart Janus and try again."
              				);
              			} else {
              				bootbox.alert(msg["error"]);
              			}
              		}
              	}
              }
              if(jsep) {
              	Janus.debug("Handling SDP as well...", jsep);
              	pluginHandler.handleRemoteJsep({ jsep });
              	// Check if any of the media we wanted to publish has
              	// been rejected (e.g., wrong or unsupported codec)
              	const audio = msg["audio_codec"];
              	if(myStream && myStream.getAudioTracks() && myStream.getAudioTracks().length > 0 && !audio) {
              		// Audio has been rejected
              		toastr.warning("Our audio stream has been rejected, viewers won't hear us");
              	}
              	const video = msg["video_codec"];
              	if(myStream && myStream.getVideoTracks() && myStream.getVideoTracks().length > 0 && !video) {
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
              if($('#myvideo').length === 0) {
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
              if(pluginHandler.webrtcStuff.pc.iceConnectionState !== "completed" &&
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
              if(!videoTracks || videoTracks.length === 0) {
              	// No webcam
              	$('#myvideo').hide();
              	if($('#videolocal .no-video-container').length === 0) {
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
              $('#publish').click(function() { publishOwnFeed(true); });
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
  if(is_owner || is_allowed){
	$.pjax.reload({ container: "#room-button", async:false });
	$.pjax.reload({ container: "#room-request", async:false });
	$.pjax.reload({ container: "#room-member", async:false });
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
    data: { uuid:room_uuid, user_id },
    cache: false,
  });
}
function newRemoteFeed(id, display, audio, video) {
  // A new feed has been published, create a new plugin handle and attach to it as a subscriber
  var remoteFeed = null;
  $('#publish').attr('disabled', true).unbind('click');
  janus.attach({
    plugin: "janus.plugin.videoroom",
    opaqueId: opaqueId,
    success: function (pluginHandle) {
      remoteFeed = pluginHandle;
      remoteFeed.simulcastStarted = false;
      Janus.log(
        "Plugin attached! (" +
          remoteFeed.getPlugin() +
          ", id=" +
          remoteFeed.getId() +
          ")"
      );
      Janus.log("  -- This is a subscriber");
      // We wait for the plugin to send us an offer
      var subscribe = {
        request: "join",
        room: room_uuid,
        ptype: "subscriber",
        feed: id,
        private_id: mypvtid,
      };
      // In case you don't want to receive audio, video or data, even if the
      // publisher is sending them, set the 'offer_audio', 'offer_video' or
      // 'offer_data' properties to false (they're true by default), e.g.:
      // 		subscribe["offer_video"] = false;
      // For example, if the publisher is VP8 and this is Safari, let's avoid video
      if (
        Janus.webRTCAdapter.browserDetails.browser === "safari" &&
        (video === "vp9" || (video === "vp8" && !Janus.safariVp8))
      ) {
        if (video) video = video.toUpperCase();
        toastr.warning(
          "Publisher is using " +
            video +
            ", but Safari doesn't support it: disabling video"
        );
        subscribe["offer_video"] = false;
      }
      remoteFeed.videoCodec = video;
      remoteFeed.send({ message: subscribe });
    },
    error: function (error) {
      Janus.error("  -- Error attaching plugin...", error);
      bootbox.alert("Error attaching plugin... " + error);
    },
    onmessage: function (msg, jsep) {
      Janus.debug(" ::: Got a message (subscriber) :::", msg);
      var event = msg["videoroom"];
      Janus.debug("Event: " + event);
      if (msg["error"]) {
        bootbox.alert(msg["error"]);
      } else if (event) {
        if (event === "attached") {
          // Subscriber created and attached
          for (var i = 1; i < 6; i++) {
            if (!feeds[i]) {
              feeds[i] = remoteFeed;
              remoteFeed.rfindex = i;
              break;
            }
          }
          remoteFeed.rfid = msg["id"];
          remoteFeed.rfdisplay = msg["display"];
          if (!remoteFeed.spinner) {
            var target = document.getElementById(
              "videoremote" + remoteFeed.rfindex
            );
            remoteFeed.spinner = new Spinner({ top: 100 }).spin(target);
          } else {
            remoteFeed.spinner.spin();
          }
          Janus.log(
            "Successfully attached to feed " +
              remoteFeed.rfid +
              " (" +
              remoteFeed.rfdisplay +
              ") in room " +
              msg["room"]
          );
          $("#remote" + remoteFeed.rfindex)
            .removeClass("hide")
            .html(remoteFeed.rfdisplay)
            .show();
        } else if (event === "event") {
          // Check if we got a simulcast-related event from this publisher
          var substream = msg["substream"];
          var temporal = msg["temporal"];
          if (
            (substream !== null && substream !== undefined) ||
            (temporal !== null && temporal !== undefined)
          ) {
            if (!remoteFeed.simulcastStarted) {
              remoteFeed.simulcastStarted = true;
              // Add some new buttons
              addSimulcastButtons(
                remoteFeed.rfindex,
                remoteFeed.videoCodec === "vp8"
              );
            }
            // We just received notice that there's been a switch, update the buttons
            updateSimulcastButtons(remoteFeed.rfindex, substream, temporal);
          }
        } else {
          // What has just happened?
        }
      }
      if (jsep) {
        Janus.debug("Handling SDP as well...", jsep);
        // Answer and attach
        remoteFeed.createAnswer({
          jsep: jsep,
          // Add data:true here if you want to subscribe to datachannels as well
          // (obviously only works if the publisher offered them in the first place)
          media: { audioSend: false, videoSend: false }, // We want recvonly audio/video
          success: function (jsep) {
            Janus.debug("Got SDP!", jsep);
            var body = { request: "start", room: room_uuid };
            remoteFeed.send({ message: body, jsep: jsep });
          },
          error: function (error) {
            Janus.error("WebRTC error:", error);
            bootbox.alert("WebRTC error... " + error.message);
          },
        });
      }
    },
    iceState: function (state) {
      Janus.log(
        "ICE state of this WebRTC PeerConnection (feed #" +
          remoteFeed.rfindex +
          ") changed to " +
          state
      );
    },
    webrtcState: function (on) {
      Janus.log(
        "Janus says this WebRTC PeerConnection (feed #" +
          remoteFeed.rfindex +
          ") is " +
          (on ? "up" : "down") +
          " now"
      );
    },
    onlocalstream: function (stream) {
      // The subscriber stream is recvonly, we don't expect anything here
    },
    onremotestream: function (stream) {
      Janus.debug("Remote feed #" + remoteFeed.rfindex + ", stream:", stream);
      var addButtons = false;
      if ($("#remotevideo" + remoteFeed.rfindex).length === 0) {
        addButtons = true;
        // No remote video yet
        $("#videoremote" + remoteFeed.rfindex).append(
          '<video class="rounded centered" id="waitingvideo' +
            remoteFeed.rfindex +
            '" width="100%" height="100%" />'
        );
        $("#videoremote" + remoteFeed.rfindex).append(
          '<video class="rounded centered relative hide" id="remotevideo' +
            remoteFeed.rfindex +
            '" width="100%" height="100%" autoplay playsinline/>'
        );
        $("#videoremote" + remoteFeed.rfindex).append(
          '<span class="label label-primary hide" id="curres' +
            remoteFeed.rfindex +
            '" style="position: absolute; bottom: 0px; left: 0px; margin: 15px;"></span>' +
            '<span class="label label-info hide" id="curbitrate' +
            remoteFeed.rfindex +
            '" style="position: absolute; bottom: 0px; right: 0px; margin: 15px;"></span>'
        );
        // Show the video, hide the spinner and show the resolution when we get a playing event
        $("#remotevideo" + remoteFeed.rfindex).bind("playing", function () {
          if (remoteFeed.spinner) remoteFeed.spinner.stop();
          remoteFeed.spinner = null;
          $("#waitingvideo" + remoteFeed.rfindex).remove();
          if (this.videoWidth)
            $("#remotevideo" + remoteFeed.rfindex)
              .removeClass("hide")
              .show();
          var width = this.videoWidth;
          var height = this.videoHeight;
          $("#curres" + remoteFeed.rfindex)
            .removeClass("hide")
            .text(width + "x" + height)
            .show();
          if (Janus.webRTCAdapter.browserDetails.browser === "firefox") {
            // Firefox Stable has a bug: width and height are not immediately available after a playing
            setTimeout(function () {
              var width = $("#remotevideo" + remoteFeed.rfindex).get(
                0
              ).videoWidth;
              var height = $("#remotevideo" + remoteFeed.rfindex).get(
                0
              ).videoHeight;
              $("#curres" + remoteFeed.rfindex)
                .removeClass("hide")
                .text(width + "x" + height)
                .show();
            }, 2000);
          }
        });
      }
      Janus.attachMediaStream(
        $("#remotevideo" + remoteFeed.rfindex).get(0),
        stream
      );
      var videoTracks = stream.getVideoTracks();
      if (!videoTracks || videoTracks.length === 0) {
        // No remote video
        $("#remotevideo" + remoteFeed.rfindex).hide();
        if (
          $("#videoremote" + remoteFeed.rfindex + " .no-video-container")
            .length === 0
        ) {
          $("#videoremote" + remoteFeed.rfindex).append(
            '<div class="no-video-container">' +
              '<i class="fa fa-video-camera fa-5 no-video-icon"></i>' +
              '<span class="no-video-text">No remote video available</span>' +
              "</div>"
          );
        }
      } else {
        $(
          "#videoremote" + remoteFeed.rfindex + " .no-video-container"
        ).remove();
        $("#remotevideo" + remoteFeed.rfindex)
          .removeClass("hide")
          .show();
      }
      if (!addButtons) return;
      // if (
      //   Janus.webRTCAdapter.browserDetails.browser === "chrome" ||
      //   Janus.webRTCAdapter.browserDetails.browser === "firefox" ||
      //   Janus.webRTCAdapter.browserDetails.browser === "safari"
      // ) {
      //   $("#curbitrate" + remoteFeed.rfindex)
      //     .removeClass("hide")
      //     .show();
      //   bitrateTimer[remoteFeed.rfindex] = setInterval(function () {
      //     // Display updated bitrate, if supported
      //     var bitrate = remoteFeed.getBitrate();
      //     $("#curbitrate" + remoteFeed.rfindex).text(bitrate);
      //     // Check if the resolution changed too
      //     var width = $("#remotevideo" + remoteFeed.rfindex).get(0).videoWidth;
      //     var height = $("#remotevideo" + remoteFeed.rfindex).get(
      //       0
      //     ).videoHeight;
      //     if (width > 0 && height > 0)
      //       $("#curres" + remoteFeed.rfindex)
      //         .removeClass("hide")
      //         .text(width + "x" + height)
      //         .show();
      //   }, 1000);
      // }
    },
    oncleanup: function () {
      Janus.log(" ::: Got a cleanup notification (remote feed " + id + ") :::");
      if (remoteFeed.spinner) remoteFeed.spinner.stop();
      remoteFeed.spinner = null;
      $("#remotevideo" + remoteFeed.rfindex).remove();
      $("#waitingvideo" + remoteFeed.rfindex).remove();
      $("#novideo" + remoteFeed.rfindex).remove();
      $("#curbitrate" + remoteFeed.rfindex).remove();
      $("#curres" + remoteFeed.rfindex).remove();
      if (bitrateTimer[remoteFeed.rfindex])
        clearInterval(bitrateTimer[remoteFeed.rfindex]);
      bitrateTimer[remoteFeed.rfindex] = null;
      remoteFeed.simulcastStarted = false;
      $("#simulcast" + remoteFeed.rfindex).remove();
    },
  });
}

function joinMe() {
  const register = {
    request: "join",
    room: room_uuid,
    ptype: "publisher",
    display: username,
  };
  pluginHandler.send({ message: register });
}

function unpublishOwnFeed() {
  // Unpublish our stream
  $("#unpublish").attr("disabled", true).unbind("click");
  var unpublish = { request: "unpublish" };
  pluginHandler.send({ message: unpublish });
}
function toggleMute() {
  var muted = pluginHandler.isAudioMuted();
  Janus.log((muted ? "Unmuting" : "Muting") + " local stream...");
  if (muted) pluginHandler.unmuteAudio();
  else pluginHandler.muteAudio();
  muted = pluginHandler.isAudioMuted();
  $("#mute").html(muted ? "Unmute" : "Mute");
}

function publishOwnFeed(useAudio) {
  // Publish our stream
  pluginHandler.createOffer({
    // Add data:true here if you want to publish datachannels as well
    media: {
      audioRecv: false,
      videoRecv: false,
      audioSend: useAudio,
      videoSend: true,
    }, // Publishers are sendonly
    // If you want to test simulcasting (Chrome and Firefox only), then
    // pass a ?simulcast=true when opening this demo page: it will turn
    // the following 'simulcast' property to pass to janus.js to true
    simulcast: doSimulcast,
    simulcast2: doSimulcast2,
    success: function (jsep) {
      Janus.debug("Got publisher SDP!", jsep);
      let publish = { request: "configure", audio: useAudio, video: true };
      // You can force a specific codec to use when publishing by using the
      // audiocodec and videocodec properties, for instance:
      // 		publish["audiocodec"] = "opus"
      // to force Opus as the audio codec to use, or:
      // 		publish["videocodec"] = "vp9"
      // to force VP9 as the videocodec to use. In both case, though, forcing
      // a codec will only work if: (1) the codec is actually in the SDP (and
      // so the browser supports it), and (2) the codec is in the list of
      // allowed codecs in a room. With respect to the point (2) above,
      // refer to the text in janus.plugin.videoroom.jcfg for more details.
      // We allow people to specify a codec via query string, for demo purposes
      if (acodec) publish["audiocodec"] = acodec;
      if (vcodec) publish["videocodec"] = vcodec;
      pluginHandler.send({ message: publish, jsep });
    },
    error: function (error) {
      Janus.error("WebRTC error:", error);
      if (useAudio) {
        publishOwnFeed(false);
      } else {
        bootbox.alert("WebRTC error... " + error.message);
        $("#publish")
          .removeAttr("disabled")
          .click(function () {
            publishOwnFeed(true);
          });
      }
    },
  });
}

function getQueryStringValue(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}