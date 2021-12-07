$(document).ready(function(){
    $('#patients-external-search-button').click(function (){
        let _patientsSearchForm = $('#patients-search-form');
        _patientsSearchForm.attr('action', '/patient/import');
        _patientsSearchForm.submit();
    });
});