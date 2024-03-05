<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="chat-container">
        <div class="chatbot">
            <header>
                <h2>Chatbot</h2>
            </header>


            <ul class="chatbox">
                <li class="message received">Hello, this is Chatbot</li>
                <!-- Chat messages will be inserted here via JavaScript -->

            </ul>

            <p id="CharacterCount">Character count: 0</p>

            <form class="user-input">
                <input type="text" name="myInput" id="inputfield" placeholder="Type your message..." oninvalid="alert('You must fill out the message!');" required>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
    <script src="script.js"></script>


</body>

</html>