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
const REQUEST_MODERATE = "moderate";
const REQUEST_UNPUBLISH = "unpublish";

const PUBLISH_TYPE_PUBLISHER = "publisher";
const PUBLISH_TYPE_SUBSCRIBER = "subscriber";

const EVENT_JOINED = "joined";
const EVENT_DESTROYED = "destroyed";
const EVENT = "event";
const EVENT_ATTACHED = "attached";
const ERROR_CODE_ROOM_NOT_FOUND = 426;

const ICE_CONNECTION_STATE_COMPLETED = "completed";
const ICE_CONNECTION_STATE_CONNECTED = "connected";

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
  connectMQTT();
  handleCountdown(endTime);

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

$(".btn-leave").on("click", () => {
  unpublishOwnFeed();
});
$(".btn-join-again").on("click", () => {
  $(".header-nav").show();
  $(".boxes").show();
  $(".sidebar").hide();
  resetTabOnSidebar();

  $(".join-again").hide();
  publishOwnFeed(true);
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
                  // message: '<div><img src="up_arrow.png"/></div>',
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
              console.log("eveeeeenr", event, message, jsep);
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
                  '<video class="rounded centered relative" width="100%" height="100%" id="myvideo" autoplay playsinline muted="muted"/>'
                );
                $("#video-source0 .username-on-call").text(username);
              }
              $(".box0").removeClass("d-none");
              Janus.attachMediaStream($("#myvideo").get(0), stream);
              $("#myvideo").get(0).muted = "muted";
              if (
                pluginHandler.webrtcStuff.pc.iceConnectionState !==
                ICE_CONNECTION_STATE_COMPLETED &&
                pluginHandler.webrtcStuff.pc.iceConnectionState !==
                ICE_CONNECTION_STATE_CONNECTED
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
                      margin: "0 auto",
                      with: "30%",
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
              if (own_mute_audio) {
                toggleMute(true);
              }
              if (own_mute_video) {
                toggleVideo(true);
              }
            },
            onremotestream: (stream) => {
              console.log(stream, "stream");
            },
            oncleanup: () => {
              Janus.log(
                " ::: Got a cleanup notification: we are unpublished now :::"
              );
              myStream = null;
              $(".header-nav").hide();
              $(".boxes").hide();
              $(".sidebar").hide();
              $(".join-again").removeClass("d-none").show();
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
  fullScreenBehavior()
  dish()
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
    if (
      leaving === "ok" &&
      objMessage["reason"] &&
      objMessage["reason"] === "kicked"
    ) {
      // TODO: handle kick
      alert("you are kicked");
      window.location.replace("/");
    } else {
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
        $(".box" + remoteFeed.rfindex).hide();
        $("#videoremote" + remoteFeed.rfindex).empty();
        $(".profile_id_" + remoteFeed.rfuser.idFeed).removeClass('text-success');
        // $(`.box${remoteFeed.rfindex}`).hide();
        // $(`.box${remoteFeed.rfindex} h1`).text("");
        feeds[remoteFeed.rfindex] = null;
        remoteFeed.detach();
      }
    }
  } else if (objMessage["unpublished"]) {
    // One of the publishers has unpublished?
    const unpublished = objMessage["unpublished"];
    if (unpublished === "ok") {
      // That's us
      // TODO: update UI local client
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
        console.log('nico',$(".profile_id_" + remoteFeed.rfuser.idFeed) )
      $(".profile_id_" + remoteFeed.rfuser.idFeed).removeClass('text-success');
      $("#videoremote" + remoteFeed.rfindex).empty();
      $(".box" + remoteFeed.rfindex).hide();
      feeds[remoteFeed.rfindex] = null;

      remoteFeed.detach();
    }
  } else if (objMessage["error"]) {
    if (objMessage["error_code"] === ERROR_CODE_ROOM_NOT_FOUND) {
      // This is a "no such room" error: give a more meaningful description
      bootbox.alert(
        "<p>Apparently room <code>" +
        myRoom +
        "</code> (the one this demo uses as a test room) " +
        "does not exist...</p><p>Do you have an updated <code>janus.plugin.videoroom.jcfg</code> " +
        "configuration file? If not, make sure you copy the details of room <code>" +
        myRoom +
        "</code> " +
        "from that sample in your current configuration file, then restart Janus and try again."
      );
    } else {
      bootbox.alert(objMessage["error"]);
    }
  } else if (objMessage["kicked"]) {
    // TODO: reset ui
    console.log("member ", objMessage["kicked"], "was kicked");
    const index = getIndexByMemberId(objMessage["kicked"]);
    if (!index) {
      return;
    }
    $(`.box${index}`).hide();
    $(`#remotevideo${index}`).empty();
    // TODO: improve text connect 
    $(`#attendee_${index}`).removeClass('text-success'); 
  }
};
const joinMe = () => {
  const register = {
    request: REQUEST_JOIN,
    room: myRoom,
    ptype: PUBLISH_TYPE_PUBLISHER,
    display: `${username}_${userProfileId}`,
    data: true,
  };
  pluginHandler.send({ message: register });
};

const publishOwnFeed = (useAudio = true, useVideo = true) => {
  pluginHandler.createOffer({
    media: {
      audioRecv: false,
      videoRecv: false,
      audioSend: useAudio,
      videoSend: useVideo,
      data: true,
    },
    simulcast: DO_SIMULCAST,
    simulcast2: DO_SIMULCAST2,
    success: function (jsep) {
      Janus.debug("Got publisher SDP!", jsep);
      let publish = {
        request: REQUEST_CONFIGURE,
        audio: useAudio,
        video: useVideo,
      };
      if (AUDIO_CODEC) publish["audiocodec"] = AUDIO_CODEC;
      if (VIDEO_CODEC) publish["videocodec"] = VIDEO_CODEC;
      pluginHandler.send({ message: publish, jsep });
    },
    error: function (error) {
      Janus.error("WebRTC error:", error);
      if (useAudio) {
        publishOwnFeed(false, false);
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
      let subscribe = {
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
      remoteFeed.audioCodec = audio;
      remoteFeed.send({ message: subscribe });
    },
    error: function (error) {
      Janus.error("  -- Error attaching plugin...", error);
      bootbox.alert("Error attaching plugin... " + error);
    },
    onmessage: function (msg, jsep) {
      const event = msg["videoroom"];
      Janus.debug("Event: " + event);
      if (msg["error"]) {
        bootbox.alert(msg["error"]);
      } else if (event) {
        if (event === EVENT_ATTACHED) {
          for (let i = 1; i < limitMembers; i++) {
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
          $(".box" + remoteFeed.rfindex).show();
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
          const subStream = msg["substream"];
          const temporal = msg["temporal"];
          if (
            (subStream !== null && subStream !== undefined) ||
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
            updateSimulcastButtons(remoteFeed.rfindex, subStream, temporal);
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
        $(`#video-source${remoteFeed.rfindex} .username-on-call`).text(
          feeds[remoteFeed.rfindex].rfuser.usernameFeed
        );
        // $("#video-source" + remoteFeed.rfindex).append(
        //   '<h1 class="text-light " style="position: absolute; top: 0px; left: 0px; margin: 25px;">' +
        //     feeds[remoteFeed.rfindex].rfuser.usernameFeed +
        //     "</h1>"
        // );
        const compList = $(`.profile_id_${remoteFeed.rfuser.idFeed}`);
        if (compList.length === 0) {
          $(`#attendee_${remoteFeed.rfindex}`).removeClass("d-none").addClass(`profile_id_${remoteFeed.rfuser.idFeed}`).addClass('text-success').show();
          $(`span.usernameFeed${remoteFeed.rfindex}`).text(remoteFeed.rfuser.usernameFeed);
        }else{
          compList.addClass('text-success');
        }

        // Show the video, hide the spinner and show the resolution when we get a playing event
        irmStatus.forEach((v) => {
          if (v.id === remoteFeed.rfid) {
            if (v.mute_audio === true) {
              $(
                ".video-mute-icon",
                $(`#video-source${remoteFeed.rfindex}`)
              ).removeClass("d-none");
              $(".btn-remote-mute > i", $(`#attendee_${remoteFeed.rfindex}`))
                .removeClass("fa-microphone")
                .addClass("fa-microphone-slash");
            }
            if (v.mute_video === true) {
              handleToggleVideoRemote(
                { ...v, video: "true", profile_image: null },
                remoteFeed.rfindex
              );
            }
          }
        });
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
      $(".box" + remoteFeed.rfindex).removeClass("d-none");
      Janus.attachMediaStream(
        $("#remotevideo" + remoteFeed.rfindex).get(0),
        stream
      );

      const videoTracks = stream.getVideoTracks();
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
      dish()
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
      dish()
    },
  });
}

function unpublishOwnFeed() {
  const unpublish = { request: REQUEST_UNPUBLISH };
  pluginHandler.send({ message: unpublish });
}

function toggleVideo(forceMute = null) {
  let muted = pluginHandler.isVideoMuted();

  Janus.log((muted ? "No video" : "Video") + " local stream...");
  if ((muted && forceMute === null) || forceMute === false) {
    pluginHandler.unmuteVideo();
  } else if ((!muted && forceMute === null) || forceMute === true) {
    pluginHandler.muteVideo();
  }
  muted = pluginHandler.isVideoMuted();
  $.post({
    url: "/room/toggle-media",
    data: { uuid: myRoom, user_profile_id: userProfileId, video: muted },
    cache: false,
    error: (err) => {
      return;
    },
  });
  if (muted) {
    $("#no-video > i").removeClass("fa-video").addClass("fa-video-slash");
  } else {
    $("#no-video > i").removeClass("fa-video-slash").addClass("fa-video");
  }
}

function toggleMute(forceMute = null) {
  let muted = pluginHandler.isAudioMuted();

  Janus.log((muted ? "Unmuting" : "Muting") + " local stream...");
  if ((muted && forceMute === null) || forceMute === false) {
    pluginHandler.unmuteAudio();
  } else if ((!muted && forceMute === null) || forceMute === true) {
    pluginHandler.muteAudio();
  }
  muted = pluginHandler.isAudioMuted();

  $.post({
    url: "/room/toggle-media",
    data: { uuid: myRoom, user_profile_id: userProfileId, audio: muted },
    cache: false,
    error: (err) => {
      return;
    },
  });

  // $("#mute").html(muted ? "Unmute" : "Mute");
  if (muted) {
    $("#mute > i").removeClass("fa-microphone").addClass("fa-microphone-slash");
  } else {
    $("#mute > i").removeClass("fa-microphone-slash").addClass("fa-microphone");
  }
}

////////////////////////////////////////////////////////////
///////////   PAHO MQTT HANDLE
////////////////////////////////////////////////////////////
$(document).on("click", "#btnJoin", function (e) {
  joinHandler("request", userProfileId);
});

$(document).on("click", "#btnAllow", function (e) {
  joinHandler("allow", $(this).data("user"));
});

$(document).on("click", "#btnDeny", function (e) {
  joinHandler("deny", $(this).data("user"));
});

function joinHandler(action, userProfileId) {
  $.post({
    url: "/room/join/" + action,
    data: { uuid: myRoom, user_profile_id: userProfileId },
    cache: false,
    error: (err) => {
      console.log(err);
    },
  });
}

function fullScreenBehavior(index = null) {
  let actionAdd = true;
  var currIdx = null
  curr = document.getElementsByClassName("fullscreen-mode");
  if (typeof curr[0] == "object" && index === null) {
    currIdx = curr[0].id.match(/\d+/)[0]
  }
  if (index !== null) {
    currIdx = index
    let newElm = document.getElementById("fullscreen_" + index)
    if (typeof curr == "object" && curr.length > 0 && curr[0].id != newElm.id) {
      curr[0].classList.remove("fullscreen-mode")
      currIcon = curr.querySelector("i")
      if (typeof currIcon == "object") {
        currIcon.classList.remove("fa-compress")
        currIcon.classList.add("fa-expand")
      }
    }
    if (typeof curr == "object" && curr.length > 0 && curr[0].id == newElm.id) {
      currIcon = curr[0].querySelector("i")
      curr[0].classList.remove("fullscreen-mode")
      if (typeof currIcon == "object") {
        currIcon.classList.remove("fa-compress")
        currIcon.classList.add("fa-expand")
      }
      actionAdd = false
    }
    if (typeof curr != "object" && index === null) {
      actionAdd = false
    }
    if (typeof newElm == "object" && actionAdd === true) {
      newElm.classList.add("fullscreen-mode")
      newElmIcon = newElm.querySelector("i");
      if (typeof newElmIcon == "object") {
        newElmIcon.classList.add("fa-compress")
        newElmIcon.classList.remove("fa-expand")
      }
    }
  }

  boxes = document.querySelectorAll('div[id^="box-"]');
  if (boxes.length > 0) {
    boxes.forEach((elm) => {
      if (actionAdd === true && parseInt(elm.getAttribute("data-id")) !== 0 && currIdx !== null) {
        if (!elm.classList.contains("video-fullcreen-none") && parseInt(elm.getAttribute("data-id")) !== parseInt(currIdx)) {
          elm.classList.add("video-fullcreen-none")
        }
      } else {
        elm.classList.remove("video-fullcreen-none")
      }
    })
  }
  dish()
}

const pinMember = (index) => {
  const boxClassComp = Array.from($(".box"));
  const boxPinned = boxClassComp.find((boxComp) =>
    $(boxComp).hasClass("pinned")
  );
  if (!boxPinned) pinBehavior(boxClassComp, index);
  else {
    if (Number($(boxPinned).attr("data-id")) === Number(index)) {
      unpinBehavior(boxClassComp, index);
    } else {
      switchingComponents(boxPinned, index);
    }
  }
};

const switchingComponents = (compPinnedToUnpin, indexToPin, width = 100) => {
  const compControl = $(".room-user-control .content-calls");
  const compVideos = $(".room-section");
  const indexAlreadyPinned = Number($(compPinnedToUnpin).attr("data-id"));
  // reset component pinned and move to list
  $(compPinnedToUnpin).removeClass("pinned");
  $(compPinnedToUnpin).attr("style", `width:${width}%`);
  $(`.box${indexAlreadyPinned} .btn-pin`).text("pin");
  compControl.append(compPinnedToUnpin);
  // get component to list, adapt it and move as pinned component
  $(`.box${indexToPin}`).attr("style", `width:${width}%`);
  $(`.box${indexToPin}`).addClass("pinned");
  $(`.box${indexToPin} .btn-pin`).text("pinned");
  compVideos.append($(`.box${indexToPin}`));
};

const unpinBehavior = (list, index, width = 20) => {
  const compVideos = $(".room-section");
  $(`.box${index} .btn-pin`).text("pin");
  list.forEach((boxComp) => {
    $(boxComp).attr("style", `width:${width}%`);
    $(boxComp).removeClass("pinned");
    compVideos.append(boxComp);
  });
};

const pinBehavior = (list, index, width = "100%", height = "90vh") => {
  const compControl = $(".room-user-control .content-calls");

  list.forEach((boxComp) => {
    $(boxComp).attr("style", `width:${width}`);
    if (Number($(boxComp).attr("data-id")) !== Number(index)) {
      compControl.append(boxComp);
    } else {
      $(boxComp).addClass("pinned");
      $(`.box${index} .btn-pin`).text("pinned");
    }
  });
};

let moderateRequest = [];

function moderateAudioToggle(elm, idx) {
  if (!isOwner) {
    return;
  }
  if (moderateRequest.indexOf(idx + "audio") >= 0) {
    return;
  }
  let muted = null;
  if (elm.querySelector("i").classList.contains("fa-microphone")) {
    muted = false;
  } else {
    muted = true;
  }
  let fnOnSuccess = function (res) {
    if (res.moderate_audio === true) {
      elm.querySelector("i").classList.add("fa-microphone-slash");
      elm.querySelector("i").classList.remove("fa-microphone");
    } else {
      elm.querySelector("i").classList.add("fa-microphone");
      elm.querySelector("i").classList.remove("fa-microphone-slash");
    }
  };

  moderateMember(idx, "audio", !muted, fnOnSuccess);
}

function moderateVideoToggle(elm, idx) {
  if (!isOwner) {
    return;
  }
  if (moderateRequest.indexOf(idx + "video") >= 0) {
    return;
  }
  let muted = null;
  if (elm.querySelector("i").classList.contains("fa-video")) {
    muted = false;
  } else {
    muted = true;
  }
  let fnOnSuccess = function (res) {
    if (res.moderate_video === true) {
      elm.querySelector("i").classList.add("fa-video-slash");
      elm.querySelector("i").classList.remove("fa-video");
    } else {
      elm.querySelector("i").classList.add("fa-video");
      elm.querySelector("i").classList.remove("fa-video-slash");
    }
  };

  moderateMember(idx, "video", !muted, fnOnSuccess);
}

function moderateMember(idx, source, mute = true, onSuccess) {
  let remoteHandler = feeds[idx];
  if (!remoteHandler) {
    return false;
  }
  sourceAvailb = ["audio", "video"];

  if (sourceAvailb.indexOf(source) < 0) {
    return false;
  }

  if (moderateRequest.indexOf(idx + source) >= 0) {
    return false;
  }
  moderateRequest.push(idx + source);
  $.post({
    url: `/room-moderate/${myRoom}/` + remoteHandler.rfuser.idFeed,
    data: { source: source, mute: mute },
    success: (res) => {
      onSuccess(res);
      let mIdx = moderateRequest.indexOf(idx + source);
      if (mIdx > -1) {
        moderateRequest.splice(mIdx, 1);
      }
    },
    error: (err) => {
      let mIdx = moderateRequest.indexOf(idx + source);
      if (mIdx > -1) {
        moderateRequest.splice(mIdx, 1);
      }
    },
  });
}

const kickMember = (index) => {
  if (isOwner) {
    let remoteHandler = feeds[index];
    if (!remoteHandler) {
      return;
    }
    $.post({
      url: `${myRoom}/kick`,
      data: {
        profileId: remoteHandler.rfuser.idFeed,
        memberId: remoteHandler.rfid,
      },
      cache: false,
      error: (err) => {
        console.log(err);
      },
      success: (data) => console.log("success", data),
    });
  }
};

////////////////////////////////////////////////////////////////////////////////
///////////////////////// HANDLING SIDEBAR
////////////////////////////////////////////////////////////////////////////////
let targetActive = null;
$(".option-side").on("click", (e) => {
  const hrefControl =
    $(e.target).attr("data-bs-target") ||
    $(e.target).find("button").attr("data-bs-target");
  if ($("#pills-tabContent").css("display") === "none") {
    $("#pills-tabContent").css("display", "block");
    dish()
  } else {
    if (targetActive === hrefControl) {
      resetTabOnSidebar();
    } else {
      if (hrefControl) {
        targetActive = hrefControl;
      }
    }
  }
});
const resetTabOnSidebar = () => {
  $("#pills-tabContent").css("display", "none");
  setTimeout(() => {
    $(`.nav-link`).removeClass("active");
    targetActive = null;
    dish()
  }, 10);
};
$(".option-side .icon-menu").on("click", (e) => {
  e.preventDefault();
  e.stopPropagation();
  $(e.target).parent().parent().trigger("click");
});

////////////////////////////////////////////////////////////////////////////////
///////////////////////// HANDLING SIDEBAR -> ATTENDEES
////////////////////////////////////////////////////////////////////////////////
$(".icon-option-member").on("click", (e) => {
  $(e.target).parent().trigger("click");
});

$(document).on("click", ".btn-remote-kick", function (e) {
  const currentElement = $(e.target);
  const index = currentElement.parent().parent().attr("data-index");
  if (index) {
    if (confirm("Are you sure that kick this member?")) {
      kickMember(index);
    }
  }
});

$(".username-on-call").on("click", (e) => {
  const indexClicked = Number(
    $(e.target).parent().parent().parent().attr("data-id")
  );
  loadAndOpenModalInfo(indexClicked);
});

const loadAndOpenModalInfo = (indexClicked) => {
  const profile_id =
    indexClicked === 0 ? userProfileId : getRemoteProfileToFeed(indexClicked);

  if (!profile_id) {
    // TODO:  what happen?
    return;
  }
  const modalInfoComponent = $("#modalInfoUser");
  $.get(`/user/get-profile/${profile_id}`)
    .then((resp) => {
      const { data } = resp;

      if (data.image) {
        modalInfoComponent.find(".image-profile img").show();
        modalInfoComponent.find("i.icon-profile").hide();
        modalInfoComponent
          .find(".image-profile img")
          .attr("src", `${location.origin}/${data.image}`);
      } else {
        modalInfoComponent.find("i.icon-profile").removeClass("d-none").show();
        modalInfoComponent.find(".image-profile img").hide();
      }
      modalInfoComponent.find("p.full-name-profile").text(`${data.image}`);
      modalInfoComponent
        .find("p.full-name-profile")
        .text(`${data.first_name || ""} ${data.last_name || ""}`);
      modalInfoComponent.find("p.nickname-profile").text(`${data.username}`);
      modalInfoComponent.find("p.email-profile").text(`${data.email}`);
      modalInfoComponent.find("p.phone-profile").text(`${data.phone || ""}`);
    })
    .catch((err) => console.log(err));

  modalInfoComponent.modal("show");
};

const getRemoteProfileToFeed = (index) => {
  const feed = feeds[index];
  if (!feed) return null;
  return feed.rfuser.idFeed;
};
const getFeedByProfileId = (profileId) => {
  const feed = feeds.find((fe) => fe?.rfuser?.idFeed === profileId);
  if (!feed) return null;
  return feed;
};
const getFeedByMemberId = (id) => {
  const feed = feeds.find((fe) => fe?.rfid === id);
  if (!feed) return null;
  return feed;
};
const getIndexByMemberId = (id) => {
  let index = null;
  feeds.forEach((feed, i) => {
    if (feed?.rfid === id) {
      index = i;
    }
  });
  return index;
};
