function setCookie(key, uuid, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  const expires = `expires=${d.toUTCString()}`;
  document.cookie = `${key}=${uuid};${expires};path=/`;
}

function getCookie(uuid) {
  const name = `${uuid}=`;
  const cookieString = document.cookie.split(";");
  for (let i = 0; i < cookieString.length; i++) {
    let c = cookieString[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

(function checkCookie() {
  let user = getCookie("username");
  if (user === "") {
    user = createID();
    uuid = user;
    if (user !== "" && user != null) {
      setCookie("username", user, 365);
    }
  } else {
    uuid = user;
  }
})();
