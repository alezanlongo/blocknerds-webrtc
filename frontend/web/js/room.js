$(document).ready(function () {
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

    if (objData.type === "Message Arrived") {
      console.log("Message Arrived: " + message.payloadString);
      $.pjax.reload({ container: "#join-room" });
    }
  };

  function connect() {
    client.connect({
      onSuccess: () => {
        client.subscribe("room");
        console.log("Connected!");
      },
    });
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

function joinHandler(action, userId) {
  $.post({
    url: "/room/join/" + action,
    data: { uuid, user_id: userId },
    cache: false,
  });
}
