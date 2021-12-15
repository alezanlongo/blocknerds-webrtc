const compModal = $('#modalDetails')

$('.btn-open-detail').on('click', (e) => {
    const logId = Number($(e.currentTarget).attr('data-id'))
    const log = logs.find(l => l.id === logId)
    if(!log){
        alert('log details not found.')
        return;
    }
    const {type, description} = log.sdp
    console.log(description)
    compModal.find('.modal-body h5').text(type)
    compModal.find('.modal-body p').text(description)
    compModal.modal('show')
})
