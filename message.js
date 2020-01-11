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
}

function getMessages(contactId) {
  fetch(
    `controllers/messageController.php?uuid=${uuid}&from_user=${contactId}`,
    {
      method: "GET",
      headers: {
        "Content-Type": "application/json"
      }
    }
  )
    .then(response => response.json())
    .then(response => buildMessages(response, contactId))
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
      const timestamp = new Date(Date.parse(data.TIME)).toISOString();

      uuid === data.FROM_USER ? content.classList.add("sender") : "";
      content.innerHTML = `${data.MESSAGE} <div class="timestamp">${timestamp}</div>`;
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

  fetch("controllers/messageController.php", {
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
