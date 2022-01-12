var calendar;

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        timeZone: 'UTC',
        contentHeight: 'auto',
        themeSystem: 'bootstrap',
        handleWindowResize: true,
        initialView: initialView,
        eventClick: function(info) {
            jQuery("#bookappointment").modal("show");
            jQuery('#appointmentId').val(info.event.id);
            jQuery('#select2-patient-firstname-container').text('');

            info.el.style.borderColor = 'red';
        },
        bootstrapFontAwesome: true,
        headerToolbar: {center: 'timeGridDay,timeGridWeek,dayGridMonth,listWeek', end: 'prev,today,next'},
        events: {
            url: actionSlots,
            method: 'GET',
            extraParams:
            function() { // a function that returns an object
                return {
                    departmentid: document.getElementById('requestcreateappointment-departmentid').value,
                    providerid: document.getElementById('requestcreateappointment-providerid').value
                };
            }
        },
        views: {
            month: {
                dayMaxEvents: 2
            },
            week: {
                dayMaxEvents: 20
            }
        },
        editable: true,
        droppable: true
    });

    calendar.render();


    $('#filter').on('click', function(e) {
        e.preventDefault();
        calendar.refetchEvents();
    });

    $('#book').on('click', function (e){
        e.preventDefault();

        var patientId = $('#patientId').val();
        var appointmentId = $('#appointmentId').val();
        $.ajax({
            type: "POST",
            url: actionBook,
            data: { patientId: patientId, appointmentId:appointmentId },
                beforeSend: function(){
                    $("#loading-overlay").show();
                },
                success: function(response)
                {
                    calendar.refetchEvents();
                    $("#bookappointment").modal("hide");
                    $("#loading-overlay").hide();
                },
                error: function( jqXHR, textStatus, errorThrown){
                    $("#loading-overlay").hide();
                    alert(textStatus);
                }

            });


    })

});

