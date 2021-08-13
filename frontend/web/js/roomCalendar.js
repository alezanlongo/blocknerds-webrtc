document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: events,
        eventClick: function (info) {
            var room_id = info.event.extendedProps.room_id;
            $.pjax.reload({ container: "#calendar-request", async: false, data: { room_id } });
            $('#scheduledRoom').modal('show');
        }
    });
    calendar.render();
});

function addMemberToList(user, uuid, room_id) {

    $.post("/room/add-member", { uuid, user_id: user.id }, function () {
        $('#user-username').val(null).trigger('change');
    })
        .done(function () {
        })
        .fail(function () {
            alert("Oops! Something went wrong please try again later");
        })
        .always(function () {
            $.pjax.reload({ container: "#calendar-request", async: false, data: { room_id } });
        });

}

function removeMemberFromList(room_id, user_id) {

    $.post("/room/remove-member", { room_id, user_id })
        .done(function () {
        })
        .fail(function () {
            alert("Oops! Something went wrong please try again later");
        })
        .always(function () {
            $.pjax.reload({ container: "#calendar-request", async: false, data: { room_id } });
        });

}
