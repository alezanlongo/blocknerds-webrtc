function sendChatRoom() {
    const text = $(`input[name=message]`).val()
    const room = $(`input[name=room_id]`).val()

    if (text.trim() === '' || !room) {
        return;
    }

    sendChatMessageMQTT(text, null, null, room);

    $(`input[name=message]`).val("")
}

$('.btn-send').on('click', (e) => {
    sendChatRoom();
});

$(`input[name=message]`).keypress(function (e) {
    if (e.which == 13) {
        sendChatRoom();
    }
});
