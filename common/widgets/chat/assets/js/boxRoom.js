function requestSubscribe(to = null, room = null) {
  var channel;

  $.ajax({
    async: false,
    type: "POST",
    url: "/chat/request-subscribe",
    data: {
      to, room
    },
    success: function (data) {
      data = JSON.parse(data);
      channel = data.channel;
    },
    error: function (data) {
      console.log('requestSubscribe error', data);
    }
  });

  return channel;
}

function sendMessageToRoom() {
  const text = $(`input[name=message-onToRoom]`).val()
  const room = $(`input[name=room_id]`).val()

  if (text.trim() === '' || !room) {
    return;
  }

  sendChatMessageMQTT(text, null, null, room);

  $(`input[name=message-onToRoom]`).val("")
}

$(`input[name=message-onToRoom]`).keypress(function (e) {
  if (e.which == 13) {
    sendMessageToRoom();
  }
});

$(document).on('keypress', ".message-onToOne", function (e) {
  if (e.which == 13) {
    var channel = $(this).attr('data-channel');
    $(`#btn-send-onToOne_${channel}`).click();
  }
});

const openChatBox = (to_profile_id, to_username, room, channel = null) => {

  if (!channel) {
    channel = requestSubscribe(to_profile_id, room);
  }

  const boxes = Array.from($('.direct-chat-gral'))

  if (boxes.length > 0) {
    const box = boxes.find(b => Number($(b).attr('data-profile-id')) === to_profile_id)

    if (box) {
      return;
    }
  }

  const chat = { to_profile_id, to_username, channel }

  $.get(`/chat/${channel}`).then(data => {
    $('.chat-zone').append(chatBox(data, chat, room))
  }).then(() => {
    chatScrollDown(`oneTone_${channel}`);
  }).catch(err => {
    console.log('Error getting chat messages', err)
  })
}

const chatBox = (content, userTarget, room) => {
  return `<div class="card direct-chat direct-chat-gral direct-chat-primary m-0" id="chat_box_${userTarget.channel}" data-profile-id="${userTarget.to_profile_id}">
      <div class="card-header">
        <h3 class="card-title">${userTarget.to_username}</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-lte-dismiss="card-remove" onclick="closeChatBox('${userTarget.channel}')">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body" id="card_collapse_${userTarget.channel}">
        <div class="direct-chat-messages oneTone_${userTarget.channel}" id="messages_${userTarget.channel}">
          ${buildContent(content)}
        </div>
      </div>
      <div class="card-footer">
          <div class="input-group">
            <input type="text" autocomplete="off" name="message-onToOne-${userTarget.channel}" id="message_to_${userTarget.channel}" data-channel="${userTarget.channel}" data-to-profile-id="${userTarget.to_profile_id}" placeholder="Type Message ..." class="form-control messageBox message-onToOne">
            <span class="input-group-append">
              <button type="button" class="btn btn-primary" id="btn-send-onToOne_${userTarget.channel}" onclick="sendMessageToUser(${userTarget.to_profile_id},'${userTarget.channel}', ${room})">Send</button>
            </span>
          </div>
      </div>
    </div>`;
}

const buildContent = (chats) => {
  return chats.map(chat => buildMessage(chat)).join('\n')
}

const closeChatBox = (channel) => {
  $(`#chat_box_${channel}`).remove();
}

const buildMessage = (chat) => {
  return `<div class="direct-chat-msg ${chat.wasMe ? 'end' : ''}">
    <div class="direct-chat-infos clearfix">
      <span class="direct-chat-timestamp float-end">${chat.sent_at}</span>
    </div>
    <img class="direct-chat-img" src="${chat.image || '/img/default-user.png'}" alt="message user image">
    <div class="direct-chat-text">
    ${chat.message}
    </div>
  </div>`
}

const sendMessageToUser = (to, channel, room) => {
  const text = $(`#message_to_${channel}`).val()

  if (to === '' || text.trim() === '') {
    return;
  }

  var chat = sendChatMessageMQTT(text, channel, to, room);
  chat = JSON.parse(chat.responseText);

  handleMessageToUser(true, chat.created_at, chat.channel, chat.message);
}

const handleMessageToUser = (wasMe, created_at, channel, message) => {
  var sent_at = moment.unix(parseInt(created_at)).format("YYYY-MM-DD HH:mm:ss");

  chat = buildMessage({ wasMe, sent_at, channel, message });

  $(`#messages_${channel}`).append(chat);

  $(`#message_to_${channel}`).val('')

  chatScrollDown(`oneTone_${channel}`);
}