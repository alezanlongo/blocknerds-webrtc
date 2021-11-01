$(document).ready(function () {

  connectMQTT(myToken);

  $(document).on("keypress", ".messageBox", function (e) {
    const charKey = e.keyCode || e.which;
    if (charKey === 13) {
      const comp = $(e.target)
      const to = comp.attr('data-to-profile-id')
      const channel = comp.attr('id').split('message_to_')[1]
      sendMessage(to, channel)
        .then(data => {
          console.log(data, 'op')
        })
        .catch(err => console.log('ERROR', err))
    }
  });
});

const openBox = (to_profile_id, to_username, channel) => {
  const chat = { to_profile_id, to_username, channel }
  $.get(`/chat/${channel}`).then(data => {
    $('.chat-zone').append(chatBox(data, chat))
  }).catch(err => {
    console.log(err)
  })
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

const buildContent = (chats) => {
  let str = '';
  chats.forEach(chat => {
    str += buildMessage(chat);
  });

  return str;
}

const sendMessage = (to, channel) => {
  const text = $(`#message_to_${channel}`).val()
  if (text.trim() === '') {
    return;
  }

  return sendMessageMQTT(text, channel, to).then(data => {
    $(`#message_to_${channel}`).val('')
    return data
  })
}

const chatBox = (content, userTarget) => {
  return `<div class="card direct-chat direct-chat-primary m-0">
    <div class="card-header">
      <h3 class="card-title">${userTarget.to_username}</h3>

      <div class="card-tools">
        <a class="btn btn-tool" data-bs-toggle="collapse" href="#card_collapse_${userTarget.channel}" role="button" aria-expanded="false" aria-controls="collapseCard">
        <i class="fas fa-minus"></i>
      </a>
        <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane">
          <i class="fas fa-comments"></i>
        </button>
        <button type="button" class="btn btn-tool" data-lte-dismiss="card-remove">
          <i class="fas fa-times"></i>
        </button>
      </div>
    </div>
    <div class="card-body" id="card_collapse_${userTarget.channel}">
      <!-- Conversations are loaded here -->
      <div class="direct-chat-messages">
        ${buildContent(content)}
      </div>
    </div>
    <div class="card-footer">
        <div class="input-group">
          <input type="text" autocomplete="off" name="message" id="message_to_${userTarget.channel}" data-to-profile-id="${userTarget.to_profile_id}" placeholder="Type Message ..." class="form-control messageBox">
          <span class="input-group-append">
            <button type="button" class="btn btn-primary" onclick="sendMessage(${userTarget.to_profile_id},'${userTarget.channel}')">Send</button>
          </span>
        </div>
    </div>
  </div>`;
}