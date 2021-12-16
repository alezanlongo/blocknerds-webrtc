const compModal = $('#modalDetails')
const compSpinner = $('#spinnerLog')

const openModal = async (id) => {
    compSpinner.removeClass('d-none').show()
    const log = await getLog(id)
    if (!log) {
        alert('log details not found.')
        return;
    }
    compSpinner.addClass('d-none').hide()
    const { type, description } = log.sdp
    compModal.find('.modal-body h5').text(type)
    compModal.find('.modal-body p').text(description)
    compModal.modal('show')
}

$('.btn-refresh').on('click', (e) => {
    $.pjax.reload({ container: "#ice-log-table" });
})

const getLog = (id) => {
    return $.get(`ice-event/get-log`, { id }).then(data => data).catch(err => console.log(err))
}