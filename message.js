init();

function init() {
  setInterval(() => {
    const sendTo = document.getElementById("send-to").value;
    if (sendTo) {
      getMessages();
    } else {
      nothingFound();
    }
  }, 2500);
}

function getMessages() {
  fetch(`/bunq/messages.php?uuid=${uuid}`, {
    method: "GET",
    headers: {
      "Content-Type": "application/json"
    }
  })
    .then(response => response.json())
    .then(response => buildMessages(response))
    .catch(() => {
      document.getElementById("message-history").innerHTML =
        "An error occurred";
    });
}

function buildMessages(response) {
  document.getElementById("message-history").innerHTML = "";
  const messageContainer = document.getElementById("message-history");
  if (!response.length) {
    nothingFound();
  } else {
    response.forEach(data => {
      const content = document.createElement("div");
      const timestamp = new Date(data.TIME);
      content.innerHTML = `${data.MESSAGE} <div class="timestamp">${timestamp}</div>`;
      messageContainer.appendChild(content);
    });
  }
}

function nothingFound() {
  document.getElementById("message-history").innerHTML = "No messages found";
}

function sendMessage() {
  const dto = {
    message: document.getElementById("message").value,
    to: document.getElementById("send-to").value,
    from: uuid
  };

  fetch("/bunq/messages.php", {
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
