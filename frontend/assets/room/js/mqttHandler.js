const EVENT_TYPE_REQUEST_JOIN = "request_join";
const EVENT_TYPE_RESPONSE_JOIN = "response_join";
const EVENT_TYPE_TOGGLE_MUTE = "toggle_mute_remote";
const EVENT_TYPE_TOGGLE_MEDIA = "request_toggle_media";
const EVENT_TYPE_CAPTURE_IMAGE = "request_capture_image";
// const wsbroker = "localhost"; // mqtt websocket enabled broker
// const wsport = 15675; // port for above
var mqtt = mqtt;
var client = mqtt.connect({ host: wsbroker, port: wsport, protocol: "ws", path: "/ws", clientId: "myclientid_" + parseInt(Math.random() * 100, 10) });
client.on('connect', function () {
  client.subscribe(window.location.pathname, function (err) {
    if (!err) {
      client.publish(window.location.pathname, 'mqtt connected!')
    }
  })
})


client.on('message', function (topic, message) {
  let objData = message.toString();
  try {
    objData = JSON.parse(objData)
  } catch (error) {
    return;
  }

  if (objData.type === EVENT_TYPE_CAPTURE_IMAGE && Number(userProfileId) === Number(objData.profile_id)) {
    // processRoomImageCapture();
    imageCap.capture()
  }


  if (objData.type === 'moderate_user_source' && Number(userProfileId) === Number(objData.profile_id)) {

    if (objData.moderate_audio === true && objData.moderate_audio_change === true) {
      toggleMute(true)
      let elmMuteBtn = document.getElementById("mute")
      elmMuteBtn.disabled = true;
    } else if (objData.moderate_audio === false && objData.moderate_audio_change === true) {
      toggleMute(true)
      let elmMuteBtn = document.getElementById("mute")
      elmMuteBtn.disabled = false;
    }

    if (objData.moderate_video === true && objData.moderate_video_change === true) {
      toggleVideo(true)
      let elmMuteBtn = document.getElementById("no-video")
      elmMuteBtn.disabled = true;
    } else if (objData.moderate_video === false && objData.moderate_video_change === true) {
      toggleVideo(true)
      let elmMuteBtn = document.getElementById("no-video")
      elmMuteBtn.disabled = false;
    }
  }

  if (objData.type === EVENT_TYPE_TOGGLE_MEDIA) {
    if (Number(userProfileId) === Number(objData.profile_id)) {
      if (objData.video !== null) {
        handleToggleVideoLocal(objData)
      }

    } else {
      const feed = getFeedByProfileId(Number(objData.profile_id));
      if (feed) {
        if (objData.video !== null) {
          handleToggleVideoRemote(objData, feed.rfindex);
        }
        if (objData.audio !== null) {
          toggleAudioMuteView(objData, feed.rfindex)
        }
      }

    }
  }

  if (objData.type === EVENT_TYPE_REQUEST_JOIN) {
    $.pjax.reload({ container: "#room-request", async: false });
    $.pjax.reload({ container: "#room-member", async: false });
    if (isOwner) {
      $("#pendingRequests").modal("show");
    }
  }

  if (objData.type === EVENT_TYPE_RESPONSE_JOIN) {
    $.pjax.reload({ container: "#room-request", async: false });
    $.pjax.reload({ container: "#room-member", async: false });
    if (
      Number(objData.user_profile_id) === Number(userProfileId) &&
      !isOwner &&
      objData.status === 1 // 1 = Allowed
    ) {
      location.reload();
    }
  }
});

const sendMessageMQTT = (type, data) => {
  const objData = {
    type,
    data,
  };
  client.publish(window.location.pathname, JSON.stringify(objData))
};

const handleToggleVideoRemote = (objData, index) => {
  const compVideo = $(`#remotevideo${index}`);
  const compImage = $(`#img${index}`);
  if (objData.video === "true") {
    if (objData.profile_image !== null) {
      compImage.attr("src", `${location.origin}/${objData.profile_image}`);
    }
    const width = compVideo.width();
    const height = compVideo.height();
    // compImage.width(width);
    // compImage.height(height);
    compImage.removeClass("d-none").show();
    compVideo.addClass("d-none").hide();
  } else {
    compImage.addClass("d-none").hide();
    compVideo.removeClass("d-none").show();
  }
};

function toggleAudioMuteView(objData, index) {
  const elm = $(`#video-source${index}`);
  const participantComponent = $(`#attendee_${index}`);
  if (objData.audio === "true") {
    $(".video-mute-icon", elm).removeClass("d-none")
    // $(".btn-remote-mute > i", participantComponent).removeClass("fa-microphone").addClass("fa-microphone-slash")
  } else {
    $(".video-mute-icon", elm).addClass("d-none")
    // $(".btn-remote-mute > i", participantComponent).removeClass("fa-microphone-slash").addClass("fa-microphone")
  }
}

const handleToggleVideoLocal = (objData) => {
  const compVideo = $("#myvideo")
  const compImage = $("#img0")
  console.log(objData)
  if (objData.video === "true") {
    $("#no-video > i").removeClass("fa-video").addClass("fa-video-slash");
    if (objData.profile_image !== null) {
      compImage.attr("src", `${location.origin}/${objData.profile_image}`);
    }
    const width = compVideo.width();
    const height = compVideo.height();
    // compImage.width('auto');
    // compImage.height(height);
    compImage.removeClass("d-none").show();
    compVideo.addClass("d-none").hide();
  } else {
    $("#no-video > i").removeClass("fa-video-slash").addClass("fa-video");
    compImage.addClass("d-none").hide();
    compVideo.removeClass("d-none").show();
  }
}