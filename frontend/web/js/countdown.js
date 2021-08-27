const handleCountDownOver = () =>{
    sendHandler('expired',userId);
}

const handleCountDownOverResponse = () =>{
    sendHandler('expired',userId);
}
$('#btnAddMoreTime').on('click', (e)=>{
    sendHandler('add',userId);
})


function sendHandler(action,user_id) {
    $.post({
      url: "/room/time/"+action,
      data: { uuid: myRoom, user_id },
      cache: false,
      error: (err) => {
        console.log(err);
      },
    });
  }