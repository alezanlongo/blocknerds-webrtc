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
  $.pjax.reload({ container: "#room-request", async: false });
  $.pjax.reload({ container: "#room-member", async: false });

  if (isOwner && objData.type === "request_join") {
    $("#pendingRequests").modal("show");
  }

  if (objData.type === "response_join") {
    if (
      Number(objData.user_id) === Number(userId) &&
      !isOwner &&
      objData.status === 1
    ) {
      location.reload();
    }
  }

  if (objData.type === "moving_screens") {
    console.log("asdasd");
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

// const sendMessageMQTT = (type, data) => {
//   const objData = {
//     type,
//     data,
//   };
//   const message = new Paho.MQTT.Message(JSON.stringify(objData));
//   message.destinationName = window.location.pathname;
//   client.send(message);
// };
