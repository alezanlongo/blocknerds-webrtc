$('.btn-send').on('click', (e) => {
    const message = $(`input[name=message]`).val()
    const targetId = $(`select[name=user_target]`).val()

    if (message.trim() === '' || !targetId) {
        return;
    }

    $.post('chat/send-message', {
        targetId,
        message,
    }).then(data => {
        // TODO: update 
        console.log(data)
    }).catch(err => console.log(err))
})