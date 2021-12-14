const sendSDPLog = (sdpString) => {
    sendRequest({ sdp: sdpString }).then(data => console.log(data))
}

const sendRequest = (data) => {
    return $.post({
        url: '/ice/event',
        data,
        success: (data) => {
            return data
        },
        error: (err) => {
            console.log(err)
            return null;
        },
    });
}