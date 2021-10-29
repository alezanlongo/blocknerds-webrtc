const openBox = (profile_id, username) => {
  $.get('/chat/get-chat/' + profile_id).then(data => {
    $('.chat-zone').append(chatBox(data, {username}))
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
    console.log(chat)
    str += buildMessage(chat);
  });

  return str;
}

const sendMessage = (targetUserId) => {
  const text = $(`#message_to_${targetUserId}`).val()
  if (text.trim() === '') {
    return;
  }

  const message = {
    targetId: targetUserId,
    text
  }
  console.log('request message and update box', message)
}

const chatBox = (content, userTarget) => {
  return `<div class="card direct-chat direct-chat-primary m-0">
    <div class="card-header">
      <h3 class="card-title">${userTarget.username}</h3>

      <div class="card-tools">
        <a class="btn btn-tool" data-bs-toggle="collapse" href="#card_collapse_${userTarget.id}" role="button" aria-expanded="false" aria-controls="collapseCard">
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
    <div class="card-body" id="card_collapse_${userTarget.id}">
      <!-- Conversations are loaded here -->
      <div class="direct-chat-messages">
        ${buildContent(content)}
      </div>
    </div>
    <div class="card-footer">
        <div class="input-group">
          <input type="text" autocomplete="off" name="message" id="message_to_${userTarget.id}" placeholder="Type Message ..." class="form-control messageBox">
          <span class="input-group-append">
            <button type="button" class="btn btn-primary" onclick="sendMessage(${userTarget.id})">Send</button>
          </span>
        </div>
    </div>
  </div>`;
}