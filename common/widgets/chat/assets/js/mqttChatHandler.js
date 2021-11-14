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
    return $.post({
        async: false,
        url: "/chat/send-message",
        data: {
            text, channel, to, room
        },
        cache: false,
        success: function (data) {
            data = JSON.parse(data);

            if (data.type === 'oneToRoom') {
                $.pjax.reload({ container: "#chat-room" });
                // console.log("Message arrived #chat-room")
            } else {
                // onToOne || oneToOneRoom
            }
        },
    });
};

let chatClient = null;

const connectChatMQTT = (channel) => {
    chatClient = mqtt.connect({ host: wsbroker, port: wsport, protocol: "ws", path: "/ws", clientId: "myclientid_" + parseInt(Math.random() * 100, 10) });

    chatClient.on('connect', function () {
        chatClient.subscribe(channel, function (err) {
            if (err) {
                console.log('mqtt err', err)
            } else {
                console.log('mqtt conneted to channel', channel)
                chatClient.publish(channel, 'mqtt connected!')
            }
        })
    })

    chatClient.on('message', function (topic, message) {
        let objData = message.toString();

        try {
            objData = JSON.parse(objData)
        } catch (error) {
            return;
        }

        const { type, channel } = objData;

        if (!type) {
            console.log("Message arrived with wrong type", objData)
        }

        if (type === 'requestToSubscribeChannel') {
            if (channels.indexOf(channel) === -1) {
                channels.push(channel);
            }
            chatClient.subscribe(channel);
        } else if (type === 'oneToRoom') {
            $.pjax.reload({ container: "#chat-room" });
        } else {
            // onToOne || oneToOneRoom

            console.log("Message arrived oneTone", objData);

            if (parseInt(objData.from) !== parseInt(userProfileId)) {
                handleMessageToUser(false, objData.created_at, objData.channel, objData.message);

                var room_id = objData.room_id ? parseInt(objData.room_id) : null;

                openChatBox(parseInt(objData.from), objData.from_username, room_id, objData.channel);
            }

            $.pjax.reload({ container: "#left-chat-list" });
        }

        console.log("Message arrived", objData)
    });
};

const chatScrollDown = (targetClass) => {
    var d = $("." + targetClass);
    d.scrollTop(d.prop("scrollHeight"));
}

$(document).on("pjax:end", function () {
    chatScrollDown('direct-chat-messages');
});

$(document).ready(function () {

    connectChatMQTT(myChannel);

    // window.setInterval(chatScrollDown('direct-chat-messages'), 500);

});
