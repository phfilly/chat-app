var apiURL = "http://chat-api/api/messages";
init();

function init() {
  setInterval(() => {
    const contactId = document.getElementById("send-to").value;
    if (contactId) {
      getMessages(contactId);
    } else {
      respondWith("Please fill in contact id or name");
    }
  }, 2500);
  document.getElementById("uuid").innerHTML = uuid;
}

function getMessages(contactId) {
  fetch(`${apiURL}?uuid=${uuid}&from_user=${contactId}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json"
    }
  })
    .then(response => response.json())
    .then(response => buildMessages(response["message"], contactId))
    .catch(() => {
      document.getElementById("message-history").innerHTML =
        "An error occurred";
    });
}

function buildMessages(response, contactId) {
  document.getElementById("message-history").innerHTML = "";
  const messageContainer = document.getElementById("message-history");
  if (!response.length) {
    respondWith(`This will be your first message to ${contactId}`);
  } else {
    response.forEach(data => {
      const content = document.createElement("div");

      uuid === data.FROM_USER ? content.classList.add("sender") : "";
      content.innerHTML = `${data.MESSAGE} <div class="timestamp">${data.TIME}</div>`;
      messageContainer.appendChild(content);
    });
  }
}

function respondWith(message) {
  document.getElementById("message-history").innerHTML = message;
}

function sendMessage() {
  const message = document.getElementById("message").value;
  if (!message.length) {
    return;
  }

  const dto = {
    message: message,
    to: document.getElementById("send-to").value,
    from: uuid
  };

  fetch(apiURL, {
    method: "POST",
    headers: {
      "Content-Type": "application/json"
    },
    body: JSON.stringify(dto)
  })
    .then(() => {
      document.getElementById("message").value = "";
    })
    .catch(error => {
      console.error("Error:", error);
    });
}

// Implemented for ease of use
var sendMessageBtn = document.getElementById("message");
sendMessageBtn.addEventListener("keyup", event => {
  if (event.keyCode === 13) {
    sendMessage();
  }
});
