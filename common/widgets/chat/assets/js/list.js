// $(document).ready(function () {

//   $(document).on("keypress", ".messageBox", function (e) {
//     const charKey = e.keyCode || e.which;
//     if (charKey === 13) {
//       const comp = $(e.target)
//       const to = comp.attr('data-to-profile-id')
//       const channel = comp.attr('id').split('message_to_')[1]
//       sendMessage(to, channel)
//         .then(data => {
//           console.log(data, 'op, do something')
//         })
//         .catch(err => console.log('ERROR', err))
//     }
//   });
// });

$(document).on('keypress', ".message-onToOne", function (e) {
  if (e.which == 13) {
    var channel = $(this).attr('data-channel');
    $(`#btn-send-onToOne_${channel}`).click();
  }
});

// const scrollLast = () => {
//   const d = $(".direct-chat-messages");
//   d.scrollTop(d.prop("scrollHeight"));
// }

const openChatBox = (to_profile_id, to_username, room_id = null, channel = null) => {

  const boxes = Array.from($('.direct-chat-gral'))

  if (boxes.length > 0) {
    const box = boxes.find(b => $(b).attr('data-channel') === channel)

    if (box) {
      const defaultColor = $(box).css("background-color")
      doEffect(box, defaultColor)
      return false;
    }
  }

  const chat = { to_profile_id, to_username, channel }

  $.get(`/chat/${channel}`).then(data => {
    $('.chat-zone').append(chatBox(data, chat, room_id))
  }).then(() => {
    chatScrollDown(`oneTone_${channel}`);
  }).catch(err => {
    console.log('Error getting chat messages', err)
  })
}

const doEffect = (comp, defaultColor, repeats = 2) => {
  if (repeats > 0) {
    $(comp).css("background-color", (repeats % 2 !== 0) ? defaultColor : "blue");
    setTimeout(() => doEffect(comp, defaultColor, repeats - 1), 500)
  }
}

// const buildMessage = (chat) => {
//   return `<div class="direct-chat-msg ${chat.wasMe ? 'end' : ''}">
//   <div class="direct-chat-infos clearfix">
//     <span class="direct-chat-timestamp float-end">${chat.sent_at}</span>
//   </div>
//   <img class="direct-chat-img" src="${chat.image || '/img/default-user.png'}" alt="message user image">
//   <div class="direct-chat-text">
//   ${chat.message}
//   </div>
// </div>`
// }

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

const sendMessageToUser = (to, channel, room = null) => {
  const text = $(`#message_to_${channel}`).val()

  if (to === '' || text.trim() === '') {
    return;
  }

  var chat = sendChatMessageMQTT(text, channel, to, room);
  chat = JSON.parse(chat.responseText);

  handleMessageToUser(true, chat.created_at, chat.channel, chat.message);

  $.pjax.reload({ container: "#left-chat-list" });
}

const handleMessageToUser = (wasMe, created_at, channel, message) => {
  var sent_at = moment.unix(parseInt(created_at)).format("YYYY-MM-DD HH:mm:ss");

  chat = buildMessage({ wasMe, sent_at, channel, message });

  $(`#messages_${channel}`).append(chat);

  $(`#message_to_${channel}`).val('')

  chatScrollDown(`oneTone_${channel}`);
}

// const sendMessage = (to, channel) => {
//   const text = $(`#message_to_${channel}`).val()
//   if (text.trim() === '') {
//     return;
//   }

//   return sendMessageMQTT(text, channel, to).then(data => {
//     $(`#message_to_${channel}`).val('')
//     return data
//   })
// }

const chatBox = (content, userTarget, room_id = null) => {
  console.log('NB', content)
  return `<div class="card direct-chat direct-chat-gral direct-chat-primary m-0" id="chat_box_${userTarget.channel}" data-channel="${userTarget.channel}">
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
              <button type="button" class="btn btn-primary" id="btn-send-onToOne_${userTarget.channel}" onclick="sendMessageToUser(${userTarget.to_profile_id},'${userTarget.channel}', ${room_id})">Send</button>
            </span>
          </div>
      </div>
    </div>`;
}

// const chatBox = (content, userTarget) => {
//   return `<div class="card direct-chat direct-chat-gral direct-chat-primary m-0" data-profile-id="${userTarget.to_profile_id}">
//     <div class="card-header">
//       <h3 class="card-title">${userTarget.to_username}</h3>
//       <div class="card-tools">
//         <a class="btn btn-tool" data-bs-toggle="collapse" href="#card_collapse_${userTarget.channel}" role="button" aria-expanded="false" aria-controls="collapseCard">
//         <i class="fas fa-minus"></i>
//       </a>
//         <button type="button" class="btn btn-tool" title="Contacts" data-lte-toggle="chat-pane">
//           <i class="fas fa-comments"></i>
//         </button>
//         <button type="button" class="btn btn-tool" data-lte-dismiss="card-remove">
//           <i class="fas fa-times"></i>
//         </button>
//       </div>
//     </div>
//     <div class="card-body" id="card_collapse_${userTarget.channel}">
//       <div class="direct-chat-messages" id="message_to_${userTarget.to_profile_id}">
//         ${buildContent(content)}
//       </div>
//     </div>
//     <div class="card-footer">
//         <div class="input-group">
//           <input type="text" autocomplete="off" name="message" id="message_to_${userTarget.channel}" data-to-profile-id="${userTarget.to_profile_id}" placeholder="Type Message ..." class="form-control messageBox">
//           <span class="input-group-append">
//             <button type="button" class="btn btn-primary" onclick="sendMessage(${userTarget.to_profile_id},'${userTarget.channel}')">Send</button>
//           </span>
//         </div>
//     </div>
//   </div>`;
// }