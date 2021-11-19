const mySidebar = $('#offcanvasMainMenu')
const maxWithSidebar = mySidebar.css('width')
const btnToggleSidebar = $('#btn-toggle-sidebar-mini');

btnToggleSidebar.on("click", (e)=>{
    btnToggleSidebar.toggleClass("down");
    if($('body').hasClass('sidebar-collapse')){
        mySidebar.animate({'width': maxWithSidebar});
        Array.from(mySidebar.find('li.nav-header')).forEach(item => $(item).removeClass('d-none'))
    }else{
        mySidebar.animate({'width': '80px'});
        Array.from(mySidebar.find('li.nav-header')).forEach(item => $(item).addClass('d-none'))
    }
})  
