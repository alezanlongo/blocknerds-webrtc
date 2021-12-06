let janus = null;
let pluginHandler = null;
let remoteFeed = null;
const opaqueId = "videoroomtest-" + Janus.randomString(12);
const server = "wss://" + window.location.hostname + ":8989/ws";
const PLUGIN_VIDEO_ROOM = "janus.plugin.videoroom";
const compLocal = $("#video-source" + user_id);
let my_private_id = null;

const REQUEST_CONFIGURE = "configure";
const REQUEST_JOIN = "join";
const TYPE_PUBLISHER = "publisher";
const TYPE_SUBSCRIBER = "subscriber";

const EVENT_JOINED = "joined";
const EVENT_DESTROYED = "destroyed";
const EVENT = "event";
const COUNT_IN_ROOM = 6;
const ERROR_CODE_ROOM_NOT_FOUND = 426;

const DO_SIMULCAST =
  getQueryStringValue("simulcast") === "yes" ||
  getQueryStringValue("simulcast") === "true";
const DO_SIMULCAST2 =
  getQueryStringValue("simulcast2") === "yes" ||
  getQueryStringValue("simulcast2") === "true";
const AUDIO_CODEC =
  getQueryStringValue("acodec") !== "" ? getQueryStringValue("acodec") : null;
const VIDEO_CODEC =
  getQueryStringValue("vcodec") !== "" ? getQueryStringValue("vcodec") : null;
const SUBSCRIBER_MODE =
  getQueryStringValue("subscriber-mode") === "yes" ||
  getQueryStringValue("subscriber-mode") === "true";

let myStream = null;
let feeds = [];
let bitrateTimer = [];

const initJanus = () => {
  Janus.init({
    debug: "all",
    callback: function () {
      janus = new Janus({
        server,
        success: function () {
          janus.attach({
            plugin: PLUGIN_VIDEO_ROOM,
            opaqueId: opaqueId,
            success: function (pluginHandle) {
              pluginHandler = pluginHandle;
              joinMe();
            },
            error: function (error) {
              Janus.error("  -- Error attaching plugin...", error);
              bootbox.alert("Error attaching plugin... " + error);
            },
            consentDialog: function (on) {
              console.log("oooooooooooooooooooooooooooon", on);
            },
            iceState: function (state) {
              console.log("iceState", state);
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
              compLocal.parent().parent().unblock();
              if (!on) return;
            },
            onmessage: function (msg, jsep) {
              const event = msg["videoroom"];
              if (event) {
                handleEvent(event, msg);
              }
              if (jsep) {
                handleJsep(msg, jsep);
              }
            },
            onlocalstream: function (stream) {
              myStream = stream;

              //   if ($("#myvideo").length === 0) {
              //     // compLocal.append(
              //     //   '<video class="rounded centered" id="myvideo" width="100%" height="100%" autoplay playsinline muted="muted"/>'
              //     // );
              //     // Add a 'mute' button
              //     // compLocal.append(
              //     //   '<button class="btn btn-warning btn-xs" id="mute" style="position: absolute; bottom: 0px; left: 0px; margin: 15px;">Mute</button>'
              //     // );
              //     // $("#mute").click(toggleMute);
              //     // // Add an 'unpublish' button
              //     // compLocal.append(
              //     //   '<button class="btn btn-warning btn-xs" id="unpublish" style="position: absolute; bottom: 0px; right: 0px; margin: 15px;">Unpublish</button>'
              //     // );
              //     // $("#unpublish").click(unpublishOwnFeed);
              //   }
              // $('#publisher').removeClass('hide').html(myusername).show();
              const compVideo = $("#myvideo" + user_id);
              Janus.attachMediaStream(compVideo.get(0), stream);
              compVideo.get(0).muted = "muted";
              if (
                pluginHandler.webrtcStuff.pc.iceConnectionState !==
                  "completed" &&
                pluginHandler.webrtcStuff.pc.iceConnectionState !== "connected"
              ) {
                compLocal
                  .parent()
                  .parent()
                  .block({
                    message: "<b>Publishing...</b>",
                    css: {
                      border: "none",
                      backgroundColor: "transparent",
                      color: "white",
                    },
                  });
              }

              //   const videoTracks = stream.getVideoTracks();
              //   if (!videoTracks || videoTracks.length === 0) {
              //     // No webcam
              //     $("#myvideo").hide();
              //     if ($("#videolocal .no-video-container").length === 0) {
              //       compLocal.append(
              //         '<div class="no-video-container">' +
              //           '<i class="fa fa-video-camera fa-5 no-video-icon"></i>' +
              //           '<span class="no-video-text">No webcam available</span>' +
              //           "</div>"
              //       );
              //     }
              //   } else {
              //     $("#videolocal .no-video-container").remove();
              //     $("#myvideo").removeClass("hide").show();
              //   }
            },
            onremotestream: function (stream) {
              // The publisher stream is sendonly, we don't expect anything here
            },
            oncleanup: function () {
              console.log("cleeeeeeeeeeeannnnn");
            },
          });
        },
        error: function (error) {
          console.log(error);
          // Janus.error(error);
          // bootbox.alert(error, function () {
          //   window.location.reload();
          // });
        },
        destroyed: function () {
          // window.location.reload();
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
    initJanus();
  }
});

function newRemoteFeed(id, display, audio, video) {
  // A new feed has been published, create a new plugin handle and attach to it as a subscriber
  
//   $("#publish").attr("disabled", true).unbind("click");
  janus.attach({
    plugin: PLUGIN_VIDEO_ROOM,
    opaqueId: opaqueId,
    success: function (pluginHandle) {
      remoteFeed = pluginHandle;
      remoteFeed.simulcastStarted = false;
      Janus.log("  -- This is a subscriber");
      // We wait for the plugin to send us an offer
      var subscribe = {
        request: REQUEST_JOIN,
        room: room_uuid,
        ptype: TYPE_SUBSCRIBER,
        feed: id,
        private_id: my_private_id,
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
      console.log(
        "aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",
        msg,
        jsep
      );
      Janus.debug("Event: " + event);
      if (msg["error"]) {
        bootbox.alert(msg["error"]);
      } else if (event) {
        if (event === "attached") {
          // Subscriber created and attached
          for (var i = 1; i < COUNT_IN_ROOM; i++) {
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

const publishOwnFeed = (useAudio) => {
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
    simulcast: DO_SIMULCAST,
    simulcast2: DO_SIMULCAST2,
    success: function (jsep) {
      let publish = {
        request: REQUEST_CONFIGURE,
        audio: useAudio,
        video: true,
      };
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
      if (AUDIO_CODEC) publish["audiocodec"] = AUDIO_CODEC;
      if (VIDEO_CODEC) publish["videocodec"] = VIDEO_CODEC;
      pluginHandler.send({ message: publish, jsep });
    },
    error: function (error) {
      Janus.error("WebRTC error:", error);
      if (useAudio) {
        publishOwnFeed(false);
      } else {
        bootbox.alert("WebRTC error... " + error.message);
        // $("#publish")
        //   .removeAttr("disabled")
        //   .click(function () {
        //     publishOwnFeed(true);
        //   });
      }
    },
  });
};

function getQueryStringValue(name) {
	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

const joinMe = () => {
  const register = {
    request: REQUEST_JOIN,
    room: room_uuid,
    ptype: TYPE_PUBLISHER,
    display: username,
  };

  pluginHandler.send({ message: register });
};

const handlingJoined = (objMessage) => {
  const myId = objMessage["id"];
  //   const myPrivateId = objMessage["private_id"];
  my_private_id = objMessage["private_id"];
  console.log("privaaaaaaaaaaaaateeeeeeee", my_private_id);

  const publishersList = objMessage["publishers"];

  if (SUBSCRIBER_MODE) {
    console.log("Do something on subscriber mode");
  } else {
    publishOwnFeed(true);
  }

  // Any new feed to attach to?
  if (publishersList) {
    for (let f in publishersList) {
      const id = publishersList[f]["id"];
      const display = publishersList[f]["display"];
      const audio = publishersList[f]["audio_codec"];
      const video = publishersList[f]["video_codec"];
      newRemoteFeed(id, display, audio, video);
    }
  }
};

const handlingDestroyed = () => {
  bootbox.alert("The room has been destroyed", function () {
    window.location.reload();
  });
};
const handlingEvent = (objMessage) => {
  if (objMessage["publishers"]) {
    const list = objMessage["publishers"];
    for (let f in list) {
      const id = list[f]["id"];
      const display = list[f]["display"];
      const audio = list[f]["audio_codec"];
      const video = list[f]["video_codec"];
      newRemoteFeed(id, display, audio, video);
    }
  } else if (objMessage["leaving"]) {
    const leaving = objMessage["leaving"];
    let remoteFeed = null;
    for (let i = 1; i < COUNT_IN_ROOM; i++) {
      if (feeds[i] && feeds[i].rfid === leaving) {
        remoteFeed = feeds[i];
        break;
      }
    }
    if (remoteFeed !== null) {
      $("#remote" + remoteFeed.rfindex)
        .empty()
        .hide();
      $("#videoremote" + remoteFeed.rfindex).empty();
      feeds[remoteFeed.rfindex] = null;
      remoteFeed.detach();
    }
  } else if (objMessage["unpublished"]) {
    // One of the publishers has unpublished?
    const unpublished = objMessage["unpublished"];
    if (unpublished === "ok") {
      // That's us
      pluginHandler.hangup();
      return;
    }
    let remoteFeed = null;
    for (let i = 1; i < COUNT_IN_ROOM; i++) {
      if (feeds[i] && feeds[i].rfid === unpublished) {
        remoteFeed = feeds[i];
        break;
      }
    }
    if (remoteFeed !== null) {
      $("#remote" + remoteFeed.rfindex)
        .empty()
        .hide();
      $("#videoremote" + remoteFeed.rfindex).empty();
      feeds[remoteFeed.rfindex] = null;
      remoteFeed.detach();
    }
  } else if (objMessage["error"]) {
    if (objMessage["error_code"] === ERROR_CODE_ROOM_NOT_FOUND) {
      // This is a "no such room" error: give a more meaningful description
      bootbox.alert(
        "<p>Apparently room <code>" +
          room_uuid +
          "</code> (the one this demo uses as a test room) " +
          "does not exist...</p><p>Do you have an updated <code>janus.plugin.videoroom.jcfg</code> " +
          "configuration file? If not, make sure you copy the details of room <code>" +
          room_uuid +
          "</code> " +
          "from that sample in your current configuration file, then restart Janus and try again."
      );
    } else {
      bootbox.alert(objMessage["error"]);
    }
  }
};
const handleEvent = (witchEvent, objMessage) => {
  switch (witchEvent) {
    case EVENT_JOINED:
      handlingJoined(objMessage);
      break;
    case EVENT_DESTROYED:
      handlingDestroyed();
      break;
    case EVENT:
      handlingEvent(objMessage);
      break;
    default:
      break;
  }
};
const handleJsep = (objMessage, jsep) => {
  pluginHandler.handleRemoteJsep({ jsep });
  // Check if any of the media we wanted to publish has
  // been rejected (e.g., wrong or unsupported codec)
  const audio = objMessage["audio_codec"];
  if (
    myStream &&
    myStream.getAudioTracks() &&
    myStream.getAudioTracks().length > 0 &&
    !audio
  ) {
    // Audio has been rejected
    alert("Our audio stream has been rejected, viewers won't hear us");
  }
  const video = objMessage["video_codec"];
  if (
    myStream &&
    myStream.getVideoTracks() &&
    myStream.getVideoTracks().length > 0 &&
    !video
  ) {
    // Video has been rejected
    alert("Our video stream has been rejected, viewers won't see us");
    // Hide the webcam video
  }
};



const handleMQTTPaho = () => {
    const wsbroker1 = "localhost"; // mqtt websocket enabled broker
    const wsport = 15675; // port for above
    const client = new Paho.MQTT.Client(
      wsbroker1,
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
      console.log(objData)
  
      $.pjax.reload({ container: "#room-button", async: false });
      $.pjax.reload({ container: "#room-request", async: false });
      $.pjax.reload({ container: "#room-member", async: false });
  
      // if (objData.type === "request_join") {
      if (is_owner && objData.type !== "request_join") {
        $.pjax.reload({ container: "#room-video" });
      }
      // }
  
      if (objData.type === "response_join") {
        if (Number(objData.user_id) === Number(user_id) && !is_owner) {
            console.log("reload")
        //   window.location.reload();
        }
      }
    };
  
    function connect() {
      client.connect({
        onSuccess: () => {
          client.subscribe(window.location.pathname);
          console.log("Connected!");
        },
      });
    }
  };
  
  $(document).on("click", "#btnJoin", function (e) {
    joinHandler("request", user_profile_id);
  });
  
  $(document).on("click", "#btnAllow", function (e) {
    joinHandler("allow", $(this).data("user"));
  });
  
  $(document).on("click", "#btnDeny", function (e) {
    joinHandler("deny", $(this).data("user"));
  });
  
  function joinHandler(action, user_profile_id) {
    $.post({
      url: "/room/join/" + action,
      data: { uuid: room_uuid, user_profile_id },
      cache: false,
    });
  }
  