<!doctype html>
<html lang="en">

<head>
  <base href="/">
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
  <link href="./bunq/style.css" rel="stylesheet">
  <script src="./bunq/cookie.js" type="text/javascript"></script>
  <script src="./bunq/message.js" type="text/javascript"></script>
  <meta charset="utf-8">
  <title>Chat App</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body class="ts3-app-body">
  <noscript>
    <p>This site is best viewed with Javascript. If you are able to turn on Javascript, please do to have the best experience.</p>
  </noscript>

  <div class="container">
    <div class="contact-container">
      To: <input id="send-to" size="40" placeholder="To address">
    </div>
    <div id="message-history" class="message-container">Loading messages...</div>
    <div class="controls">
      <input id="message" size="40" placeholder="Your message here">
      <button id="button" onClick="sendMessage()"> Send </button>
    </div>
  </div>
</body>

</html>
