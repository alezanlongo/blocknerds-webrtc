
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

const sendMessageMQTT = (text, channel = null, to = null, room = null) => {
    return $.post({
        url: "/chat/send-message",
        data: {
            text, channel, to, room
        },
        cache: false,
    });
};


const wsbroker = "localhost"; // mqtt websocket enabled broker
const wsport = 15675; // port for above
// const mqtt = mqtt;

let client = null;
const connectMQTT = (channel) => {
    client = mqtt.connect({ host: wsbroker, port: wsport, protocol: "ws", path: "/ws", clientId: "myclientid_" + parseInt(Math.random() * 100, 10) });
    client.on('connect', function () {
        client.subscribe(channel, function (err) {
            console.log('mqtt', err)
            if (!err) {
                client.publish(channel, 'mqtt connected!')
            }
        })
    })
    client.on('message', function (topic, message) {
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
            client.subscribe(channel);
        } else {
            // $("." + type).append('<p>' + objData.message + '</p>');
            // console.log($(`#message_to_${objData.to}`))

            $.pjax.reload({ container: "#left-chat-list" });
        }
        console.log("Message arrived", objData)
    });
};