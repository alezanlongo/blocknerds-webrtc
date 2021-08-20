$('.profile-image').on('click', ()=>{
    $('.input-image-profile').trigger("click")
})

$('.input-image-profile').on('change', (e)=>{
    const [file] = e.target.files
    if (file) {
      $('.profile-image').attr('src', URL.createObjectURL(file))
  }
})