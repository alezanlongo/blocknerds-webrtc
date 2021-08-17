jQuery(document).on("pjax:success", "#calendar-request", function (event) {
    if (window.jQuery) {
        jQuery('#datetimepicker').datetimepicker({
            defaultDate: $("input[name=date]").val(),
            defaultTime: $("input[name=time]").val(),
            minDate: 0,
            format: 'Y-m-d H:i:00',
            // format: 'unix',
            inline: true,
            step: 5,
            ampm: true,
        });
    }

});

var calendar;

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: "room/calendar/events/" + user_id,
        eventClick: function (info) {
            var room_id = info.event.extendedProps.room_id;
            $.pjax.reload({ container: "#calendar-request", async: false, data: { room_id } });
            $('#scheduledRoom').modal('show');
        }
    });
    calendar.render();
});

$(document).on('submit', '#formUpdateSchedule', function (e) {

    e.preventDefault();

    var fields = $(this).serializeArray();

    $(".current-member-list li").each(function () {
        fields.push({ name: "User[username][]", value: $(this).attr("data-member-id") });
    })

    var checkMembers = 1;

    $.each(fields, function () {
        if (this.name == "title") {
            if (this.value == "") {
                alert('Please select a title');
                checks = false;
                throw new Error("Field validation error: title");
            }
        }

        if (this.name == "duration") {
            if (this.value == "") {
                alert('Please select a duration');
                checks = false;
                throw new Error("Field validation error: duration");
            }
        }

        if (this.name == "datetimepicker") {
            if (this.value == "") {
                alert('Please select a date and time to schedule a room');
                checks = false;
                throw new Error("Field validation error: datetimepicker");
            }
        }

        if (this.name == "User[username][]") {
            checkMembers += 1;
        }
    });

    if (checkMembers == 1) {
        alert('Please add some members to the room');
        throw new Error("Member allowed validation error");
    }

    if (checkMembers > roomMaxMembersAllowed) {
        alert('Maximum number of member allowed in a room is ' + (parseInt(roomMaxMembersAllowed) - 1));
        throw new Error("Member allowed validation error");
    }

    $.post("/room/update-schedule", fields, function (data, status) {
        $("#user-username").empty().trigger('change');
        $('#scheduledRoom').modal('hide');
    }, "json")
        .done(function () {
        })
        .fail(function () {
            $('#scheduledRoom').modal('hide');
            alert("Oops! Something went wrong please try again later");
        })
        .always(function () {
            $("#datetimepicker").datetimepicker('reset');
            $("#formUpdateSchedule")[0].reset();
            calendar.refetchEvents();
        });
});

function addMemberToList(user) {
    $(".current-member-list li").each(function () {
        if ($(this).attr("data-member-id") == user.id) {
            $("#user-username option[value='" + user.id + "']").remove();
        }
    })
}

function removeMemberFromList(user_id) {
    $('.current-member-list').find("[data-member-id=" + user_id + "]").remove();
}

function copyToClipboard() {
    var copyText = $("input[name=roomLink]").val();

    navigator.clipboard.writeText(copyText);

    $("input[name=roomLink]").fadeOut(150).fadeIn(150);
}