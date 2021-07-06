const server = "wss://" + window.location.hostname + ":8989/ws";

let janus = null;
let textroom = null;
const opaqueId = "textroomtest-" + Janus.randomString(12);

let myroom = 1234; // Demo room
if (getQueryStringValue("room") !== "") {
  myroom = parseInt(getQueryStringValue("room"));
}
let myusername = null;
let myid = null;
let participants = {};
let transactions = {};

$(document).ready(function () {
  // Initialize the library (all console debuggers enabled)
  if (!Janus.isWebrtcSupported()) {
    bootbox.alert("No WebRTC support... ");
    return;
  }
  Janus.init({
    debug: "all",
    callback: function () {
      janus = new Janus({
        server,
        success,
        error: function (error) {
          Janus.error(error);
          bootbox.alert(error, function () {
            window.location.reload();
          });
        },
        destroyed: function () {
          window.location.reload();
        },
      });
    },
  });

  function success() {
    janus.attach({
      plugin: "janus.plugin.textroom",
      opaqueId: opaqueId,
      success: function (pluginHandle) {
        textroom = pluginHandle;

        // Setup the DataChannel
        var body = { request: "setup" };
        Janus.debug("Sending message:", body);
        textroom.send({ message: body });
        $("#start")
          .removeAttr("disabled")
          .html("Stop")
          .click(function () {
            $(this).attr("disabled", true);
            janus.destroy();
          });
      },
      error: function (error) {
        console.error("  -- Error attaching plugin...", error);
        bootbox.alert("Error attaching plugin... " + error);
      },
      iceState: function (state) {
        Janus.log("ICE state changed to " + state);
      },
      mediaState: function (medium, on) {
        Janus.log(
          "Janus " + (on ? "started" : "stopped") + " receiving our " + medium
        );
      },
      webrtcState: function (on) {
        Janus.log(
          "Janus says our WebRTC PeerConnection is " +
            (on ? "up" : "down") +
            " now"
        );
      },
      onmessage: function (msg, jsep) {
        Janus.debug(" ::: Got a message :::", msg);
        if (msg["error"]) {
          bootbox.alert(msg["error"]);
        }
        if (jsep) {
          // Answer
          textroom.createAnswer({
            jsep: jsep,
            media: { audio: false, video: false, data: true }, // We only use datachannels
            success: function (jsep) {
              Janus.debug("Got SDP!", jsep);
              var body = { request: "ack" };
              textroom.send({ message: body, jsep: jsep });
            },
            error: function (error) {
              Janus.error("WebRTC error:", error);
              bootbox.alert("WebRTC error... " + error.message);
            },
          });
        }
      },
      ondataopen: function (data) {
        Janus.log("The DataChannel is available!");
        joinUser(); // to register user
      },
      ondata: function (data) {
        // Janus.debug("We got data from the DataChannel!", data);
        // console.log(data)
        //~ $('#datarecv').val(data);
        const json = JSON.parse(data);
        const transaction = json["transaction"];
        if (transactions[transaction]) {
          // Someone was waiting for this
          transactions[transaction](json);
          delete transactions[transaction];
          return;
        }
        const what = json["textroom"];

        if (what === "message") {
          // Incoming message: public or private?
          let msg = json["text"];
          msg = msg.replace(new RegExp("<", "g"), "&lt");
          msg = msg.replace(new RegExp(">", "g"), "&gt");
          const from = json["from"];
          const dateString = getDateString(json["date"]);
          const whisper = json["whisper"];

          if (whisper) {
            // Private message
            $("#chatroom").append(
              '<p style="color: purple;">[' +
                dateString +
                "] <b>[whisper from " +
                participants[from] +
                "]</b> " +
                msg
            );
            $("#chatroom").get(0).scrollTop =
              $("#chatroom").get(0).scrollHeight;
          } else {
            // Public message
            $("#chatroom").append(
              "<p>[" +
                dateString +
                "] <b>" +
                participants[from] +
                ":</b> " +
                msg
            );
            $("#chatroom").get(0).scrollTop =
              $("#chatroom").get(0).scrollHeight;
          }
        } else if (what === "announcement") {
          // Room announcement
          var msg = json["text"];
          msg = msg.replace(new RegExp("<", "g"), "&lt");
          msg = msg.replace(new RegExp(">", "g"), "&gt");
          var dateString = getDateString(json["date"]);
          $("#chatroom").append(
            '<p style="color: purple;">[' + dateString + "] <i>" + msg + "</i>"
          );
          $("#chatroom").get(0).scrollTop = $("#chatroom").get(0).scrollHeight;
        } else if (what === "join") {
          // Somebody joined
          var username = json["username"];
          var display = json["display"];
          participants[username] = display ? display : username;
          if (username !== myid && $("#rp" + username).length === 0) {
            // Add to the participants list
            $("#list").append(
              '<li id="rp' +
                username +
                '" class="list-group-item">' +
                participants[username] +
                "</li>"
            );
            $("#rp" + username)
              .css("cursor", "pointer")
              .click(function () {
                var username = $(this).attr("id").split("rp")[1];
                sendPrivateMsg(username);
              });
          }
          $("#chatroom").append(
            '<p style="color: green;">[' +
              getDateString() +
              "] <i>" +
              participants[username] +
              " joined</i></p>"
          );
          $("#chatroom").get(0).scrollTop = $("#chatroom").get(0).scrollHeight;
        } else if (what === "leave") {
          // Somebody left
          var username = json["username"];
          var when = new Date();
          $("#rp" + username).remove();
          $("#chatroom").append(
            '<p style="color: green;">[' +
              getDateString() +
              "] <i>" +
              participants[username] +
              " left</i></p>"
          );
          $("#chatroom").get(0).scrollTop = $("#chatroom").get(0).scrollHeight;
          delete participants[username];
        } else if (what === "kicked") {
          // Somebody was kicked
          var username = json["username"];
          var when = new Date();
          $("#rp" + username).remove();
          $("#chatroom").append(
            '<p style="color: green;">[' +
              getDateString() +
              "] <i>" +
              participants[username] +
              " was kicked from the room</i></p>"
          );
          $("#chatroom").get(0).scrollTop = $("#chatroom").get(0).scrollHeight;
          delete participants[username];
          if (username === myid) {
            bootbox.alert("You have been kicked from the room", function () {
              window.location.reload();
            });
          }
        } else if (what === "destroyed") {
          if (json["room"] !== myroom) return;
          // Room was destroyed, goodbye!
          Janus.warn("The room has been destroyed!");
          bootbox.alert("The room has been destroyed", function () {
            window.location.reload();
          });
        }
      },
      oncleanup: function () {
        Janus.log(" ::: Got a cleanup notification :::");
        $("#datasend").attr("disabled", true);
      },
    });
  }
});

function checkEnter(field, event) {
  var theCode = event.keyCode
    ? event.keyCode
    : event.which
    ? event.which
    : event.charCode;
  if (theCode == 13) {
    sendData();
    return false;
  }
  return true;
}

function joinUser() {
  myid = randomString(12);
  const transaction = randomString(12);
  const register = {
    textroom: "join",
    transaction: transaction,
    room: myroom,
    username: myid,
    display: myUsername,
  };
  console.log("transactions", transactions);
  transactions[transaction] = function (response) {
    if (response["textroom"] === "error") {
      // Something went wrong
      if (response["error_code"] === 417) {
        // This is a "no such room" error: give a more meaningful description
        bootbox.alert(
          "<p>Apparently room <code>" +
            myroom +
            "</code> (the one this demo uses as a test room) " +
            "does not exist...</p><p>Do you have an updated <code>janus.plugin.textroom.jcfg</code> " +
            "configuration file? If not, make sure you copy the details of room <code>" +
            myroom +
            "</code> " +
            "from that sample in your current configuration file, then restart Janus and try again."
        );
      } else {
        bootbox.alert(response["error"]);
      }
      $("#username").removeAttr("disabled").val("");
      $("#register").removeAttr("disabled").click(registerUsername);
      return;
    }
    // We're in
    $("#roomjoin").hide();
    $("#room").removeClass("hide").show();
    $("#participant").removeClass("hide").html(myUsername).show();
    $("#chatroom").css("height", $(window).height() - 420 + "px");
    $("#datasend").removeAttr("disabled");
    // Any participants already in?
    console.log("Participants:", response.participants);
    if (response.participants && response.participants.length > 0) {
      for (var i in response.participants) {
        var p = response.participants[i];
        participants[p.username] = p.display ? p.display : p.username;
        if (p.username !== myid && $("#rp" + p.username).length === 0) {
          // Add to the participants list
          $("#list").append(
            '<li id="rp' +
              p.username +
              '" class="list-group-item">' +
              participants[p.username] +
              "</li>"
          );
          $("#rp" + p.username)
            .css("cursor", "pointer")
            .click(function () {
              var username = $(this).attr("id").split("rp")[1];
              sendPrivateMsg(username);
            });
        }
        $("#chatroom").append(
          '<p style="color: green;">[' +
            getDateString() +
            "] <i>" +
            participants[p.username] +
            " joined</i></p>"
        );
        $("#chatroom").get(0).scrollTop = $("#chatroom").get(0).scrollHeight;
      }
    }
  };
  textroom.data({
    text: JSON.stringify(register),
    error: function (reason) {
      bootbox.alert(reason);
    },
  });
}

function sendPrivateMsg(username) {
  const display = participants[username];
  if (!display) return;
  bootbox.prompt("Private message to " + display, function (result) {
    if (result && result !== "") {
      var message = {
        textroom: "message",
        transaction: randomString(12),
        room: myroom,
        to: username,
        text: result,
      };
      textroom.data({
        text: JSON.stringify(message),
        error: function (reason) {
          bootbox.alert(reason);
        },
        success: function () {
          $("#chatroom").append(
            '<p style="color: purple;">[' +
              getDateString() +
              "] <b>[whisper to " +
              display +
              "]</b> " +
              result
          );
          $("#chatroom").get(0).scrollTop = $("#chatroom").get(0).scrollHeight;
        },
      });
    }
  });
  return;
}

function sendData() {
  const data = $("#datasend").val();
  if (data === "") {
    bootbox.alert("Insert a message to send on the DataChannel");
    return;
  }
  const message = {
    textroom: "message",
    transaction: randomString(12),
    room: myroom,
    text: data,
  };
  // Note: messages are always acknowledged by default. This means that you'll
  // always receive a confirmation back that the message has been received by the
  // server and forwarded to the recipients. If you do not want this to happen,
  // just add an ack:false property to the message above, and server won't send
  // you a response (meaning you just have to hope it succeeded).
  textroom.data({
    text: JSON.stringify(message),
    error: function (reason) {
      bootbox.alert(reason);
    },
    success: function () {
      $("#datasend").val("");
    },
  });
}

// Helper to format times
function getDateString(jsonDate) {
  var when = new Date();
  if (jsonDate) {
    when = new Date(Date.parse(jsonDate));
  }
  var dateString =
    ("0" + when.getUTCHours()).slice(-2) +
    ":" +
    ("0" + when.getUTCMinutes()).slice(-2) +
    ":" +
    ("0" + when.getUTCSeconds()).slice(-2);
  return dateString;
}

// Just an helper to generate random usernames
function randomString(len, charSet) {
  charSet =
    charSet || "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
  var randomString = "";
  for (var i = 0; i < len; i++) {
    var randomPoz = Math.floor(Math.random() * charSet.length);
    randomString += charSet.substring(randomPoz, randomPoz + 1);
  }
  return randomString;
}

// Helper to parse query string
function getQueryStringValue(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}
