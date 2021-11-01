$('.btn-send').on('click', (e) => {
    const text = $(`input[name=message]`).val()
    const to = $(`select[name=user_target]`).val()

    if (text.trim() === '' || !to) {
        return;
    }

    sendMessageMQTT(text, null, to);

    closeAndClearNewMessage();
})

function closeAndClearNewMessage() {
    $(`input[name=message]`).val("")
    $(`select[name=user_target]`).prop("selectedIndex", 0).val();
    $("#newChat").modal('hide');
}