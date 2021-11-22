const mySidebar = $('#offcanvasMainMenu')
const maxWithSidebar = '400px'
const btnToggleSidebar = $('#btn-toggle-sidebar-mini');

btnToggleSidebar.on("click", (e)=>{
    btnToggleSidebar.toggleClass("down");
    const isOpen = $('body').hasClass('sidebar-collapse')
    toggleTooltips(!isOpen)
    if(isOpen){
        mySidebar.animate({'width': maxWithSidebar});
        Array.from(mySidebar.find('li.nav-header')).forEach(item => $(item).removeClass('d-none'))
    }else{
        mySidebar.animate({'width': '80px'});
        Array.from(mySidebar.find('li.nav-header')).forEach(item => $(item).addClass('d-none'))
    }
})  


const toggleTooltips = (isSidebarOpen) => {
    tooltipList.forEach(tooltip => tooltip._isEnabled = isSidebarOpen)
}