
let channels = [];
// legacy code from paho if we need later
// client.onConnectionLost = function (responseObject) {
//     console.log("Connection Lost: " + responseObject.errorMessage);
//     connectMQTT(myToken);
//     channels.forEach(function (channel) {
//         client.subscribe(channel);
//         console.log("Re-Connected to", channel);
//     });
// };

const sendChatMessageMQTT = (text, channel = null, to = null, room = null) => {
    $.post({
        url: "/chat/send-message",
        data: {
            text, channel, to, room
        },
        cache: false,
    });
};

if (typeof wsbroker !== "undefined") {
    const wsbroker = "localhost"; // mqtt websocket enabled broker
}

if (typeof wsport !== "undefined") {
    const wsport = 15675; // port for above
}

let chatClient = null;

const connectChatMQTT = (channel) => {
    chatClient = mqtt.connect({ host: wsbroker, port: wsport, protocol: "ws", path: "/ws", clientId: "myclientid_" + parseInt(Math.random() * 100, 10) });

    chatClient.on('connect', function () {
        chatClient.subscribe(channel, function (err) {
            console.log('mqtt', err)
            if (!err) {
                chatClient.publish(channel, 'mqtt connected!')
            }
        })
    })

    chatClient.on('message', function (topic, message) {
        let objData = message.toString();
        console.log('mqtt', objData)
        try {
            objData = JSON.parse(objData)
        } catch (error) {
            return;
        }

        console.log('mqtt', objData)

        const { type, channel } = objData;

        if (!type) {
            console.log("Message arrived with wrong type", objData)
        }

        if (type === 'requestToSubscribeChannel') {
            if (channels.indexOf(channel) === -1) {
                channels.push(channel);
            }
            chatClient.subscribe(channel);
        } else {

            $.pjax.reload({ container: "#chat-room" });

        }
        console.log("Message arrived", objData)
    });
};

const chatRoomScrollDown = () => {
    var d = $(".direct-chat-messages");
    d.scrollTop(d.prop("scrollHeight"));
};

$(document).on("pjax:end", function () {
    chatRoomScrollDown();
});

$(document).ready(function () {

    connectChatMQTT(myChannel);

    window.setInterval(function () {
        chatRoomScrollDown();
    }, 500);
});

