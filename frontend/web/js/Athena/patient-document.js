$(document).ready(function(){
    $('#document').change(function (){
        let urlCreateDocument = $('#create-document').attr('href');
        urlCreateDocument += '&type=' + $(this).val();
        $('#create-document').attr('href', urlCreateDocument);
        $('#create-document').removeClass('disabled');
    });
});