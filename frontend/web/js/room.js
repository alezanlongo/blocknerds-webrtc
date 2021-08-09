////////////////////////////////////////////////////////////
///////////   CONSTANTS
////////////////////////////////////////////////////////////
let janus = null;
let pluginHandler = null;
const opaqueId = "videoroomtest-" + Janus.randomString(12);
const server = "wss://" + window.location.hostname + ":8989/ws";

let my_private_id = null;
const PLUGIN_VIDEO_ROOM = "janus.plugin.videoroom";
const REQUEST_CONFIGURE = "configure";
const REQUEST_JOIN = "join";
const REQUEST_START = "start";

const PUBLISH_TYPE_PUBLISHER = "publisher";
const PUBLISH_TYPE_SUBSCRIBER = "subscriber";

const EVENT_JOINED = "joined";
const EVENT_DESTROYED = "destroyed";
const EVENT = "event";
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
////////////////////////////////////////////////////////////
///////////   ON READY
////////////////////////////////////////////////////////////
$(document).ready(function () {
  handleMQTTPaho();

  if (!Janus.isWebrtcSupported()) {
    bootbox.alert("No WebRTC support... ");
    return;
  }
  if (isOwner && countRequest > 0) {
    $("#pendingRequests").modal("show");
  }

  if (isOwner || isAllowed) {
    initJanus();
  }
});

const initJanus = () => {
  Janus.init({
    debug: "all",
    callback: () => {
      janus = new Janus({
        token: mytoken,
        server,
        success: () => {
          janus.attach({
            plugin: PLUGIN_VIDEO_ROOM,
            opaqueId,
            success: (pluginHandle) => {
              pluginHandler = pluginHandle;
              joinMe();
            },
            error: (error) => {
              Janus.error("  -- Error attaching plugin...", error);
              bootbox.alert("Error attaching plugin... " + error);
            },
            consentDialog: (on) => {
              Janus.debug(
                "Consent dialog should be " + (on ? "on" : "off") + " now"
              );
              if (on) {
                // Darken screen and show hint
                $.blockUI({
                  message: '<div><img src="up_arrow.png"/></div>',
                  css: {
                    border: "none",
                    padding: "15px",
                    backgroundColor: "transparent",
                    color: "#aaa",
                    top: "10px",
                    left: navigator.mozGetUserMedia ? "-100px" : "300px",
                  },
                });
              } else {
                // Restore screen
                $.unblockUI();
              }
            },
            iceState: (state) => {
              Janus.log("ICE state changed to " + state);
            },
            mediaState: (medium, on) => {
              Janus.log(
                "Janus " +
                  (on ? "started" : "stopped") +
                  " receiving our " +
                  medium
              );
            },
            webrtcState: (on) => {
              Janus.log(
                "Janus says our WebRTC PeerConnection is " +
                  (on ? "up" : "down") +
                  " now"
              );
              $(`#video-source0`).parent().parent().unblock();
              if (!on) return;
            },
            onmessage: (message, jsep) => {
              const event = message.videoroom;
              if (event) {
                handleEvent(event, message);
              }
              if (jsep) {
                handleJsep(message, jsep);
              }
            },
            onlocalstream: (stream) => {
              myStream = stream;
              if ($("#myvideo").length === 0) {
                $(`#video-source0`).append(
                  '<video class="rounded centered" id="myvideo" width="100%" height="100%" autoplay playsinline muted="muted"/>'
                );
                $("#video-source0").append(
                    '<h1 class="text-light " style="position: absolute; top: 0px; left: 0px; margin: 25px;">' +
                      username +
                      "</h1>"
                  );
              }
              $('.box0').removeClass('d-none')
              Janus.attachMediaStream($("#myvideo").get(0), stream);
              $("#myvideo").get(0).muted = "muted";
              if (
                pluginHandler.webrtcStuff.pc.iceConnectionState !==
                  "completed" &&
                pluginHandler.webrtcStuff.pc.iceConnectionState !== "connected"
              ) {
                $(`#video-source0`)
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
              const videoTracks = stream.getVideoTracks();
              if (!videoTracks || videoTracks.length === 0) {
                // No webcam
                $("#myvideo").hide();
                if ($("#video-source .no-video-container").length === 0) {
                  $(`#video-source0`).append(
                    '<div class="no-video-container">' +
                      '<i class="fa fa-video-camera fa-5 no-video-icon"></i>' +
                      '<span class="no-video-text">No webcam available</span>' +
                      "</div>"
                  );
                }
              } else {
                $("#video-source .no-video-container").remove();
                $("#myvideo").removeClass("hide").show();
              }
            },
            onremotestream: (stream) => {},
            oncleanup: () => {
              Janus.log(
                " ::: Got a cleanup notification: we are unpublished now :::"
              );
              myStream = null;
              $(`#video-source0`).html(
                '<button id="publish" class="btn btn-primary">Publish</button>'
              );
              $("#publish").click(function () {
                publishOwnFeed(true);
              });
              $(`#video-source0`).parent().parent().unblock();
            },
          });
        },
        error: (error) => {
          Janus.error(error);
          bootbox.alert(error, function () {
            window.location.reload();
          });
        },
        destroyed: () => {
          window.location.reload();
        },
      });
    },
  });
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
  }
};

const handlingJoined = (objMessage) => {
  const myId = objMessage["id"];
  my_private_id = objMessage["private_id"];
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
    for (let i = 1; i < limitMembers; i++) {
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
    for (let i = 1; i < limitMembers; i++) {
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
const joinMe = () => {
  const register = {
    request: REQUEST_JOIN,
    room: myRoom,
    ptype: PUBLISH_TYPE_PUBLISHER,
    display: `${username}_${userId}`,
  };
  pluginHandler.send({ message: register });
};

const publishOwnFeed = (useAudio) => {
  pluginHandler.createOffer({
    media: {
      audioRecv: false,
      videoRecv: false,
      audioSend: useAudio,
      videoSend: true,
    },
    simulcast: DO_SIMULCAST,
    simulcast2: DO_SIMULCAST2,
    success: function (jsep) {
      Janus.debug("Got publisher SDP!", jsep);
      let publish = {
        request: REQUEST_CONFIGURE,
        audio: useAudio,
        video: true,
      };
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
        //   $("#publish")
        //     .removeAttr("disabled")
        //     .click(function () {
        //       publishOwnFeed(true);
        //     });
      }
    },
  });
};

function getQueryStringValue(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  let regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function newRemoteFeed(id, display, audio, video) {
  let remoteFeed = null;
  // A new feed has been published, create a new plugin handle and attach to it as a subscriber
  janus.attach({
    plugin: PLUGIN_VIDEO_ROOM,
    opaqueId,
    success: (pluginHandle) => {
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
      var subscribe = {
        request: REQUEST_JOIN,
        room: myRoom,
        ptype: PUBLISH_TYPE_SUBSCRIBER,
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
      var event = msg["videoroom"];
      Janus.debug("Event: " + event);
      if (msg["error"]) {
        bootbox.alert(msg["error"]);
      } else if (event) {
        const EVENT_ATTACHED = "attached";
        if (event === EVENT_ATTACHED) {
          for (var i = 1; i < limitMembers; i++) {
            if (!feeds[i]) {
              const splittedString = display.split("_");
              const idFeed = Number(splittedString[1]);
              const usernameFeed = splittedString[0];
              remoteFeed.rfindex = i;
              remoteFeed.rfuser = { idFeed, usernameFeed };
              feeds[i] = remoteFeed;
              break;
            }
          }

          remoteFeed.rfid = msg["id"];
          remoteFeed.rfdisplay = msg["display"];
          if (!remoteFeed.spinner) {
            const target = document.getElementById(
              "video-source" + remoteFeed.rfindex
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
        } else if (event === EVENT) {
          // Check if we got a simulcast-related event from this publisher
          const substream = msg["substream"];
          const temporal = msg["temporal"];
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
        // Answer and attach
        remoteFeed.createAnswer({
          jsep: jsep,
          media: { audioSend: false, videoSend: false },
          success: function (jsep) {
            const body = { request: REQUEST_START, room: myRoom };
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
      let addButtons = false;
      if ($("#remotevideo" + remoteFeed.rfindex).length === 0) {
        addButtons = true;
        // No remote video yet
        $("#video-source" + remoteFeed.rfindex).append(
          '<video class="rounded centered" id="waitingvideo' +
            remoteFeed.rfindex +
            '" width="100%" height="100%" />'
        );
        $("#video-source" + remoteFeed.rfindex).append(
          '<video class="rounded centered relative hide" id="remotevideo' +
            remoteFeed.rfindex +
            '" width="100%" height="100%" autoplay playsinline/>'
        );
        $("#video-source" + remoteFeed.rfindex).append(
          '<h1 class="text-light " style="position: absolute; top: 0px; left: 0px; margin: 25px;">' +
            feeds[remoteFeed.rfindex].rfuser.usernameFeed +
            "</h1>"
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
        });
      }
      $('.box'+ remoteFeed.rfindex).removeClass('d-none')
      Janus.attachMediaStream(
        $("#remotevideo" + remoteFeed.rfindex).get(0),
        stream
      );
      var videoTracks = stream.getVideoTracks();
      if (!videoTracks || videoTracks.length === 0) {
        // No remote video
        $("#remotevideo" + remoteFeed.rfindex).hide();
        if (
          $("#video-source" + remoteFeed.rfindex + " .no-video-container")
            .length === 0
        ) {
          $("#video-source" + remoteFeed.rfindex).append(
            '<div class="no-video-container">' +
              '<i class="fa fa-video-camera fa-5 no-video-icon"></i>' +
              '<span class="no-video-text">No remote video available</span>' +
              "</div>"
          );
        }
      } else {
        $(
          "#video-source" + remoteFeed.rfindex + " .no-video-container"
        ).remove();
        $("#remotevideo" + remoteFeed.rfindex)
          .removeClass("hide")
          .show();
      }
      if (!addButtons) return;
      if (
        Janus.webRTCAdapter.browserDetails.browser === "chrome" ||
        Janus.webRTCAdapter.browserDetails.browser === "firefox" ||
        Janus.webRTCAdapter.browserDetails.browser === "safari"
      ) {
        $("#curbitrate" + remoteFeed.rfindex)
          .removeClass("hide")
          .show();
        bitrateTimer[remoteFeed.rfindex] = setInterval(function () {
          // Display updated bitrate, if supported
          var bitrate = remoteFeed.getBitrate();
          $("#curbitrate" + remoteFeed.rfindex).text(bitrate);
          // Check if the resolution changed too
          var width = $("#remotevideo" + remoteFeed.rfindex).get(0).videoWidth;
          var height = $("#remotevideo" + remoteFeed.rfindex).get(
            0
          ).videoHeight;
          if (width > 0 && height > 0)
            $("#curres" + remoteFeed.rfindex)
              .removeClass("hide")
              .text(width + "x" + height)
              .show();
        }, 1000);
      }
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
  const unpublish = { request: "unpublish" };
  pluginHandler.send({ message: unpublish });
}
function toggleMute() {
  let muted = pluginHandler.isAudioMuted();
  Janus.log((muted ? "Unmuting" : "Muting") + " local stream...");
  if (muted) pluginHandler.unmuteAudio();
  else pluginHandler.muteAudio();
  muted = pluginHandler.isAudioMuted();
  $("#mute").html(muted ? "Unmute" : "Mute");
}

////////////////////////////////////////////////////////////
///////////   PAHO MQTT HANDLE
////////////////////////////////////////////////////////////
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
    console.log(objData);
    $.pjax.reload({ container: "#room-request", async: false });
    $.pjax.reload({ container: "#room-member", async: false });

    if (isOwner && objData.type === "request_join") {
      $("#pendingRequests").modal("show");
    }

    if (objData.type === "response_join") {
      // if(Number(objData.user_id) === Number(userId)  && !isOwner){
      window.location.reload();
      //   }
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
  joinHandler("request", userId);
});

$(document).on("click", "#btnAllow", function (e) {
	joinHandler("allow", $(this).data("user"));
});

$(document).on("click", "#btnDeny", function (e) {
	joinHandler("deny", $(this).data("user"));
});

function joinHandler(action, userId) {
  $.post({
    url: "/room/join/" + action,
    data: { uuid: myRoom, user_id: userId },
    cache: false,
    error: (err) => {
      console.log(err);
    },
  });
}
