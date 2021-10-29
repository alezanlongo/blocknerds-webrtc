const wsbroker = "localhost"; // mqtt websocket enabled broker
const wsport = 15675; // port for above
const client = new Paho.MQTT.Client(
    wsbroker,
    wsport,
    "/ws",
    "myclientid_" + parseInt(Math.random() * 100, 10)
);

let channels = [];

const connectMQTT = (channel) => {
    client.connect({
        onSuccess: () => {
            client.subscribe(channel);
            console.log("Connected to", channel);
        },
    });
};

client.onConnectionLost = function (responseObject) {
    console.log("Connection Lost: " + responseObject.errorMessage);

    connectMQTT(myToken);

    channels.forEach(function (channel) {
        client.subscribe(channel);
        console.log("Re-Connected to", channel);
    });
};

client.onMessageArrived = function (message) {
    const objData = JSON.parse(message.payloadString);
    const type = objData.type;

    if (!type) {
        console.log("Message arrived with wrong type", objData)
    }

    if (type === 'requestToSubscribeChannel') {
        if (channels.indexOf(objData.channel) === -1) {
            channels.push(objData.channel);
        }
        client.subscribe(objData.channel);
    } else {
        $("." + objData.type).append('<p>' + objData.message + '</p>');
    }
    console.log("Message arrived", objData)
};

const sendMessageMQTT = (from, to, room, message) => {

    $.post({
        url: "/chat-test/message-listener",
        data: {
            from, to, room, message
        },
        cache: false,
        error: (err) => {
            console.log("Error on sendMessageMQTT", err);
        },
        success: (data) => {
            const objData = JSON.parse(data);
            console.log("Success on sendMessageMQTT", objData)
        },
    });

};

const handleSendMessage = () => {

    if ($('input[name="message1"]').val() && $('input[name="to1"]').val()) {
        sendMessageMQTT(profile_id, $('input[name="to1"]').val(), null, $('input[name="message1"]').val());
    } else if ($('input[name="message2"]').val() && $('input[name="to2"]').val() && $('input[name="room2"]').val()) {
        sendMessageMQTT(profile_id, $('input[name="to2"]').val(), $('input[name="room2"]').val(), $('input[name="message2"]').val());
    } else if ($('input[name="message3"]').val() && $('input[name="room3"]').val()) {
        sendMessageMQTT(profile_id, null, $('input[name="room3"]').val(), $('input[name="message3"]').val());
    }

    $('input[name="message1"], input[name="message2"], input[name="message3"]').val("");
};

$(document).ready(function () {

    connectMQTT(myToken);

    $(".message").keypress(function (e) {
        if (e.which == 13) {
            handleSendMessage();
        }
    });

    $(document).on("click", ".btn-primary", function (e) {
        handleSendMessage();
    });

});