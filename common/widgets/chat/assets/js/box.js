$('.btn-send').on('click', (e) => {
    const text = $(`input[name=message]`).val()
    const targetId = $(`input[name=user_target]`).val()

    if(text.trim() === '' || !targetId){
        return;
    }

    const message = {
        targetId,
        text,
    }('chat/send-message', message).then(data => {
        // TODO: update 
        console.log(data)
    }).catch(err => console.log(err))
})