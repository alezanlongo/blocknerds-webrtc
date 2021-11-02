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
    console.log(objData)
    const {type, channel} = objData;

    if (!type) {
        console.log("Message arrived with wrong type", objData)
    }

    if (type === 'requestToSubscribeChannel') {
        if (channels.indexOf(channel) === -1) {
            channels.push(channel);
        }
        client.subscribe(channel);
    } else {
        // $("." + type).append('<p>' + objData.message + '</p>');
        // console.log($(`#message_to_${objData.to}`))
        
        $.pjax.reload({ container: "#left-chat-list" });
    }
    console.log("Message arrived", objData)
};

const sendMessageMQTT = (text, channel = null, to = null, room = null) => {
   return $.post({
        url: "/chat/send-message",
        data: {
            text, channel, to, room
        },
        cache: false,
    });

};
