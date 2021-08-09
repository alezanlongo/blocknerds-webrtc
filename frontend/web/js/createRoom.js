if (window.jQuery) {
    jQuery('#datetimepicker').datetimepicker({
        minDate: 0,
        format: 'Y-m-d H:i:00',
        // format: 'unix',
        inline: true,
        step: 15,
        ampm: true,
    });
}

// $(document).on("click", "#btnCreateSchedule", function (e) {
$(document).on('submit', '#formCreateSchedule', function (e) {

    e.preventDefault();

    var fields = $(this).serializeArray();
    var offset = { name: 'offset', value: new Date().getTimezoneOffset() };
    fields.push(offset);

    var checkMembers = 1;

    $.each($(this).serializeArray(), function () {
        if (this.name == "datetimepicker") {
            if (this.value == "") {
                alert('Please select a date and time to schedule a room');
                checks = false;
                throw new Error("Date time validation error");
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

    $.post("/room/create-schedule", fields, function (data, status) {
        $("#user-username").empty().trigger('change');
        $('#planningMeeting').modal('hide');
        $('#planningMeetingSuccessfully .modal-body').html("Room created successfully!<br><br>Room's link<br>" + window.location.hostname + "/room/" + data.uuid);
        $('#planningMeetingSuccessfully').modal('show');
    }, "json")

        .done(function () {
            // $('#planningMeeting').modal('hide');
        })
        .fail(function () {
            $('#planningMeeting').modal('hide');
            alert("Oops! Something went wrong please try again later");
        })
        .always(function () {
            $("#datetimepicker").datetimepicker('reset');
        });
});
