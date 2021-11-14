$('.btn-send').on('click', (e) => {
    const text = $(`input[name=message]`).val()
    const to = $(`select[name=user_target]`).val()

    if (text.trim() === '' || !to) {
        return;
    }

    var chat = sendChatMessageMQTT(text, null, to);
    chat = JSON.parse(chat.responseText);

    closeAndClearNewMessage();

    if (openChatBox(parseInt(to), chat.to_username, null, chat.channel) === false) {
        handleMessageToUser(true, chat.created_at, chat.channel, chat.message);
    }

    chatScrollDown(`oneTone_${chat.channel}`);

})

function closeAndClearNewMessage() {
    $(`input[name=message]`).val('')
    $(`select[name=user_target]`).prop("selectedIndex", 0).val();
    $('#offcanvasScrolling .offcanvas-header .btn-close').trigger("click")
    $('#newChat').modal('hide')
}
