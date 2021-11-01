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
          console.log(data, 'op, do something')
        })
        .catch(err => console.log('ERROR', err))
    }
  });
});

const openBox = (to_profile_id, to_username, channel) => {
  const boxes = Array.from($('.direct-chat-gral'))
  if (boxes.length > 0) {
    const box = boxes.find(b => Number($(b).attr('data-profile-id')) === to_profile_id)
    if (box) {
      const defaultColor = $(box).css("background-color")
      doEfect(box, defaultColor)
      return;
    }
  }

  const chat = { to_profile_id, to_username, channel }
  $.get(`/chat/${channel}`).then(data => {
    $('.chat-zone').append(chatBox(data, chat))
  }).catch(err => {
    console.log(err)
  })
}

const doEfect = (comp, defaultColor, repeats = 2) => {
  if (repeats > 0) {
     $(comp).css("background-color", (repeats  % 2 !== 0) ? defaultColor : "blue") ;
    setTimeout(() => doEfect(comp,defaultColor, repeats - 1), 500)
  }
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
  return chats.map(chat => buildMessage(chat)).join('\n')
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
  return `<div class="card direct-chat direct-chat-gral direct-chat-primary m-0" data-profile-id="${userTarget.to_profile_id}">
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