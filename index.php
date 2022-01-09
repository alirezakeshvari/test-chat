<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat Room</title>
    <link rel="stylesheet" href="./assets/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/app.css">
</head>
<body>
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-sm-12">
                <div class="chats">
                    <div class="message-form">
                        <form method="post" id="chatForm">
                            <div class="form-group">
                                <label for="message"></label>
                                <input type="text" name="message" id="message" class="form-control" placeholder="Message .." />
                            </div>
                            <div class="text-center">
                                <input type="submit" id="subBtn" class="btn btn-primary btn-send" value="send">
                            </div>
                        </form>
                    </div>
                    <div id="messages" class="chat-box">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./lib/jquery.js"></script>
    <script> 
    $(document).ready(function() {
        var conn = new WebSocket('ws://localhost:8080');
        var chatForm = $('#chatForm');
        var userMessage = $("#message");
        var msgList = $('#messages');
        chatForm.on('submit', function(e){
            e.preventDefault();
            var message = userMessage.val();
            if (message == "") {
                alert("Please fill the message input!");
                return;
            }
            conn.send(message);
            document.getElementById("message").value = null;
            msgList.prepend("<p class='message-me'>" + message +"</p>");
        });
        conn.onopen = function(e) {
            console.log("Connection stablished");
        }
        conn.onmessage = function(e) {
            console.log(e.data);
            msgList.prepend(`<p class="message-other">${e.data}</p>`);
        }
    });
    </script>
</body>
</html>