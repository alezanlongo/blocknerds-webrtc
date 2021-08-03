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
    console.log(objData)

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
      onSuccess: () => {
        client.subscribe(window.location.pathname);
        console.log("Connected!");
      },
    });
  }
};

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
    data: { uuid: room_uuid, user_id },
    cache: false,
  });
}
