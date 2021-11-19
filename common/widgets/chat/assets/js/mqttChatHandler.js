let channels = [];

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

            if ($('#left-chat-list').length) {
                $.pjax.reload({ container: "#left-chat-list" });
            }

            if ($('#chat-room').length) {
                $.pjax.reload({ container: "#chat-room" });
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
            if ($('#chat-room').length) {
                $.pjax.reload({ container: "#chat-room" });
            } else {
                handleArrivedMessage(objData);
            }
        } else {
            // onToOne || oneToOneRoom

            console.log("Message arrived " + type, objData);

            handleArrivedMessage(objData);
        }

        if ($('#left-chat-list').length) {
            $.pjax.reload({ container: "#left-chat-list" });
        }

        console.log("Message arrived", objData)
    });
};

const handleArrivedMessage = (objData) => {

    var room_id = objData.room_id ? parseInt(objData.room_id) : null;

    if (objData.type == "oneToRoom") {
        openChatBox(null, objData.room_uuid, room_id, objData.channel);
    } else {
        if (parseInt(objData.from) !== parseInt(userProfileId)) {
            openChatBox(parseInt(objData.from), objData.from_username, room_id, objData.channel);
        }
    }

    if (parseInt(objData.from) !== parseInt(userProfileId)) {
        handleMessageToUser(objData);
    }

    console.log('nb3', objData)

    return false;
}

const chatScrollDown = (targetClass) => {
    var d = $("." + targetClass);
    d.scrollTop(d.prop("scrollHeight"));
}

$(document).on("pjax:end", function () {
    chatScrollDown('chat-room-messages');
});

$(document).ready(function () {

    connectChatMQTT(myChannel);

    // window.setInterval(chatScrollDown('direct-chat-messages'), 500);

});
