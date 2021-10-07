$('#encounter-patientstatusid').change(function (){
    let patientStatusText = $('select[id="encounter-patientstatusid"] option').filter(':selected').text();
    let patientLocationText = $('select[id="encounter-patientlocationid"] option').filter(':selected').text()

    $('#encounter-patientlocation').val(patientLocationText);
    $('#encounter-patientstatus').val(patientStatusText);
});