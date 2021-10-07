if (window.jQuery) {
  jQuery("#datetimepicker").datetimepicker({
    minDate: 0,
    format: "Y-m-d H:i:00",
    // format: 'unix',
    inline: true,
    step: 15,
    ampm: true,
  });
}

jQuery(document).on("pjax:success", "#calendar-request", function (event) {
  if (window.jQuery) {
    jQuery("#datetimepicker").datetimepicker({
      defaultDate: $("input[name=date]").val(),
      defaultTime: $("input[name=time]").val(),
      minDate: 0,
      format: "Y-m-d H:i:00",
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
    timeZone: 'UTC',
    contentHeight: 'auto',
    handleWindowResize: true,
    initialView: initialView,
    headerToolbar: { center: 'timeGridDay,timeGridWeek,dayGridMonth,listWeek' },
    events: "room/calendar/events/" + user_profile_id,
    views: {
      month: {
        dayMaxEvents: 2
      },
      week: {
        dayMaxEvents: 20
      }
    },
    editable: true,
    droppable: true,
    eventDrop: function (info) {

      if (confirm("Are you sure about this change?")) {
        console.log("drop", info.event.extendedProps, info.event.start.toUTCString());

        $.post(
          "/room/update-schedule",
          {
            room_id: info.event.extendedProps.room_id,
            datetimepicker: info.event.start.toUTCString()
          },
          "json"
        );

      } else {
        info.revert();
      }
    },
    eventClick: function (info) {
      var room_id = info.event.extendedProps.room_id;
      $.pjax.reload({ container: "#calendar-request", async: false, data: { room_id } });
      $('#scheduledRoom').modal('show');
    }
  });

  calendar.render();
  $.pjax.reload({ container: "#calendar-next-meeting" })
  setInterval(() => { $.pjax.reload({ container: "#calendar-next-meeting" }) }, 10000);

  $('.fc-timeGridDay-button, .fc-timeGridWeek-button, .fc-dayGridMonth-button, .fc-listWeek-button').click(function (e) {

    var initialView = 'timeGridDay';
    if (this.className.includes('timeGridWeek')) {
      initialView = 'timeGridWeek';
    } else if (this.className.includes('dayGridMonth')) {
      initialView = 'dayGridMonth';
    } else if (this.className.includes('listWeek')) {
      initialView = 'listWeek';
    }

    $.post("room/calendar", { initialView });
  });

});

const modalConfirm = $("#confirmMeeting");

function createSchedule() {
  const fields = $("#formCreateSchedule").serializeArray();
  const offset = { name: "offset", value: new Date().getTimezoneOffset() };
  fields.push(offset);
  let checkMembers = 1;

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

    if (this.name == "username[]") {
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

  $("#planningMeeting").modal("hide");
  updateUIConfirmModal(fields);
  modalConfirm.modal("show");
  $(".btnConfirmMeet").on("click", (e) => {
    sendCreateMeetOrder(fields);
  });
}

const updateUIConfirmModal = (fields) => {
  const description = getValue(fields, "description");
  const allowWaiting = getValue(fields, "allow_waiting") === "1";
  getComponentToShow("h3.summaryTitle", "Title", getValue(fields, "title"));
  getComponentToShow(
    "p.summaryDescription",
    "Description",
    description ? description : "unspecified value"
  );
  getComponentToShow(
    "p.summaryTime",
    "When",
    getValue(fields, "datetimepicker")
  );
  getComponentToShow(
    "p.summaryDuration",
    "Duration",
    getHowMuchTimeItIs(getValue(fields, "duration"))
  );
  getComponentToShow(
    "p.summaryReminderTime",
    "Reminder time",
    getHowMuchTimeItIs(getValue(fields, "reminder_time"))
  );
  getComponentToShow(
    "p.summaryIsWaiting",
    "Allow waiting",
    allowWaiting ? "Yes" : "No"
  );
  getComponentToShow(
    "p.summaryMembers",
    "Members",
    getAddedMembers().join(', ')
  );
};

const getValue = (fields, tag) => {
  const field = fields.find((f) => f.name === tag);
  if (!field) return "";
  return field.value;
};

const getComponentToShow = (component, label, value) => {
  modalConfirm.find(component).html(`<b>${label}: </b>${value}`);
};

$(".btnCancelMeet").on("click", (e) => {
  // TODO clear form to add meet?
  modalConfirm.modal("hide");
});

const getAddedMembers = () => {
  const parentClassSelector = "ul.select2-selection__rendered";
  const childClassSelector = "span.select2-selection__choice__display";

  return Array.from($(parentClassSelector).children()).map((child) =>
    $(child).find(childClassSelector).text()
  );
};

const sendCreateMeetOrder = (fields) => {
  $.post(
    "/room/create-schedule",
    fields,
    function (data, status) {
      $("#user-username").empty().trigger("change");
      $("#planningMeeting").modal("hide");
      modalConfirm.modal("hide");
      const baseRoomUrl = $("#planningMeetingSuccessfully input[name]").val()
      $("#planningMeetingSuccessfully input[name]").val(`${baseRoomUrl}${data.uuid}`)
      $("#planningMeetingSuccessfully").modal("show");
    },
    "json"
  )

    .done(function () {
      // $('#planningMeeting').modal('hide');
    })
    .fail(function () {
      $("#planningMeeting").modal("hide");
      alert("Oops! Something went wrong please try again later");
    })
    .always(function () {
      $("#datetimepicker").datetimepicker("reset");
      $("#formCreateSchedule")[0].reset();
      calendar.refetchEvents();
    });
};

const getHowMuchTimeItIs = (secondsStr) => {
  const sec_num = Number(secondsStr);
  let hours = Math.floor(sec_num / 3600);
  let minutes = Math.floor((sec_num - hours * 3600) / 60);
  let seconds = sec_num - hours * 3600 - minutes * 60;

  if (hours < 10) hours = `0${hours}`;
  if (minutes < 10) minutes = `0${minutes}`;
  if (seconds < 10) seconds = `0${seconds}`;

  return hours + ":" + minutes + ":" + seconds;
};

function updateSchedule() {
  var fields = $("#formUpdateSchedule").serializeArray();

  $(".current-member-list li").each(function () {
    fields.push({
      name: "User[username][]",
      value: $(this).attr("data-member-id"),
    });
  });

  var checkMembers = 1;

  $.each(fields, function () {
    if (this.name == "title") {
      if (this.value == "") {
        alert("Please select a title");
        checks = false;
        throw new Error("Field validation error: title");
      }
    }

    if (this.name == "duration") {
      if (this.value == "") {
        alert("Please select a duration");
        checks = false;
        throw new Error("Field validation error: duration");
      }
    }

    if (this.name == "datetimepicker") {
      if (this.value == "") {
        alert("Please select a date and time to schedule a room");
        checks = false;
        throw new Error("Field validation error: datetimepicker");
      }
    }

    if (this.name == "User[username][]") {
      checkMembers += 1;
    }
  });

  if (checkMembers == 1) {
    alert("Please add some members to the room");
    throw new Error("Member allowed validation error");
  }

  if (checkMembers > roomMaxMembersAllowed) {
    alert(
      "Maximum number of member allowed in a room is " +
      (parseInt(roomMaxMembersAllowed) - 1)
    );
    throw new Error("Member allowed validation error");
  }

  $.post(
    "/room/update-schedule",
    fields,
    function (data, status) {
      $("#user-username").empty().trigger("change");
      $("#scheduledRoom").modal("hide");
    },
    "json"
  )
    .done(function () { })
    .fail(function () {
      $("#scheduledRoom").modal("hide");
      alert("Oops! Something went wrong please try again later");
    })
    .always(function () {
      $("#datetimepicker").datetimepicker("reset");
      $("#formUpdateSchedule")[0].reset();
      calendar.refetchEvents();
    });
}

function addMemberToList(user) {
  $(".current-member-list li").each(function () {
    if ($(this).attr("data-member-id") == user.id) {
      $("#user-username option[value='" + user.id + "']").remove();
    }
  });
}

function removeMemberFromList(user_profile_id) {
  $(".current-member-list")
    .find("[data-member-id=" + user_profile_id + "]")
    .remove();
}

function copyToClipboard() {
  var copyText = $("input[name=roomLink]").val();

  navigator.clipboard.writeText(copyText);

  $("input[name=roomLink]").fadeOut(150).fadeIn(150);
}
