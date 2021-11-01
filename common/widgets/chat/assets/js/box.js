$('.btn-send').on('click', (e) => {
    const text = $(`input[name=message]`).val()
    const to = $(`select[name=user_target]`).val()

    if (text.trim() === '' || !to) {
        return;
    }

    sendMessageMQTT(text, null, to).then(data => {
        console.log(data)
        closeAndClearNewMessage();
        // TODO: open box
    })

})

function closeAndClearNewMessage() {
    $(`input[name=message]`).val('')
    $(`select[name=user_target]`).prop("selectedIndex", 0).val();
    $('#offcanvasScrolling .offcanvas-header .btn-close').trigger("click")
    $('#newChat').modal('hide')
}
