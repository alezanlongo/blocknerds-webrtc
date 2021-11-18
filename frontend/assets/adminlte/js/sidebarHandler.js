
$(`#btn-toggle-sidebar`).on('click', (e)=>{
    $('#sidebarMenu').animate({width: 'toggle', transition: "0.5s ease-in-out"});
})
