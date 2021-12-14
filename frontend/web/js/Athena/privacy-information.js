$(document).ready(function(){
    $('.form-check-input').click(function (){
        if($(this).is(':checked')){
            $.ajax({
                type: 'post',
                url: $('#url-post').val(),
                dataType: "json",
                data: {
                    departmentid: $('#departmentid').val(),
                    patientid: $('#patientid').val(),
                    signaturename: $(this).attr('id'),
                },
                beforeSend: function() {

                },
                success: function(data) {
                    if(data.success == true){
                        alert('Success');
                    }
                },
                error: function() {

                }
            });
        }else{

        }
    });
});