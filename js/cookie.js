function setID(uuid) {
  if (uuid) {
    localStorage.setItem(
      "chat-app",
      JSON.stringify({
        uuid: uuid,
        dateCreated: new Date()
      })
    );
  }
}

function getID(key) {
  userObj = JSON.parse(localStorage.getItem(key));
  if (userObj) {
    return userObj["uuid"];
  } else {
    return "";
  }
}

(function checkID() {
  let userId = getID("chat-app");
  if (userId === "") {
    userId = createID();
    uuid = userId;
    if (userId !== "" && userId != null) {
      setID(userId);
    }
  } else {
    uuid = userId;
  }
})();
