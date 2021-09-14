const EVENT_TYPE_REQUEST_JOIN = "request_join";
const EVENT_TYPE_RESPONSE_JOIN = "response_join";
const EVENT_TYPE_TOGGLE_MUTE = "toggle_mute_remote";
const EVENT_TYPE_TOGGLE_MEDIA = "request_toggle_media";  
const wsbroker = "localhost"; // mqtt websocket enabled broker
const wsport = 15675; // port for above
const client = new Paho.MQTT.Client(
  wsbroker,
  wsport,
  "/ws",
  "myclientid_" + parseInt(Math.random() * 100, 10)
);

client.onConnectionLost = function (responseObject) {
  console.log("Connection Lost: " + responseObject.errorMessage);
  connectMQTT();
};

client.onMessageArrived = function (message) {
  const objData = JSON.parse(message.payloadString);

  // if (objData.type === EVENT_TYPE_TOGGLE_MUTE && userProfileId === objData.data.user_profile_id) {
  //   $("#mute").html(objData.data.isMuted ? "Unmute" : "Mute");
  // }
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
};

const connectMQTT = () => {
  client.connect({
    onSuccess: () => {
      client.subscribe(window.location.pathname);
      console.log("Connected!");
    },
  });
};

const sendMessageMQTT = (type, data) => {
  const objData = {
    type,
    data,
  };
  const message = new Paho.MQTT.Message(JSON.stringify(objData));
  message.destinationName = window.location.pathname;
  client.send(message);
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
    compImage.width('auto');
    compImage.height(height);
    compImage.removeClass("d-none").show();
    compVideo.addClass("d-none").hide();
  } else {
    compImage.addClass("d-none").hide();
    compVideo.removeClass("d-none").show();
  }
};

function toggleAudioMuteView(objData, index) {
  let elm = $(`#video-source${index}`);
  if (objData.audio === "true") {
    $(".video-mute-icon", elm).removeClass("d-none")
  } else {
    $(".video-mute-icon", elm).addClass("d-none")
  }
}

const handleToggleVideoLocal = (objData) => {
  const compVideo = $("#myvideo")
  const compImage = $("#img0")
  if (objData.video === "true") {
    $("#no-video > i").removeClass("fa-video").addClass("fa-video-slash");
    if (objData.profile_image !== null) {
      compImage.attr("src", `${location.origin}/${objData.profile_image}`);
    }
    const width = compVideo.width();
    const height = compVideo.height();
    compImage.width('auto');
    compImage.height(height);
    compImage.removeClass("d-none").show();
    compVideo.addClass("d-none").hide();
  } else {
    $("#no-video > i").removeClass("fa-video-slash").addClass("fa-video");
    compImage.addClass("d-none").hide();
    compVideo.removeClass("d-none").show();
  }
  // const compVideo = $(`#remotevideo${index}`);
  // const compImage = $(`#img${index}`);
  // if (objData.video === "true") {
  //   if (objData.profile_image !== null) {
  //     const width = compVideo.width();
  //     const height = compVideo.height();
  //     compImage.attr("src", `${location.origin}/${objData.profile_image}`);
  //     compImage.width(width);
  //     compImage.height(height);
  //   }
  //   compImage.removeClass("d-none").show();
  //   compVideo.addClass("d-none").hide();
  // } else {
  //   compImage.addClass("d-none").hide();
  //   compVideo.removeClass("d-none").show();
  // }
}