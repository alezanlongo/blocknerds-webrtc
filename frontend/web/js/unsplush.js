

$(`.btn-add-photo`).on('click', (e)=>{
    e.preventDefault();
    e.stopPropagation();

    const key = $(e.currentTarget).attr('data-key');
    const form = $(`#form-add-photo-${key}`)
    const url = form.attr('action');
    
    $.post(url, form.serialize()).then(data => {
        $.pjax.reload({ container: "#flash-alert-message", async: false });
    })
    .then(()=>{
        form.trigger("reset");
    })
    .catch((err) => {
        $.pjax.reload({ container: "#flash-alert-message", async: false });
        console.error(err)
    })
});