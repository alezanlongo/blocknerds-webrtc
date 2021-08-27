const EVENT_TYPE_REQUEST_JOIN = "request_join";
const EVENT_TYPE_RESPONSE_JOIN = "response_join";
const EVENT_TYPE_TOGGLE_MUTE = "toggle_mute_remote";
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

  if (objData.type === EVENT_TYPE_TOGGLE_MUTE && userProfileId === objData.data.user_profile_id) {
    $("#mute").html(objData.data.isMuted ? "Unmute" : "Mute");
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
