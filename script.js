document.addEventListener("DOMContentLoaded", function () {
    const inputField = document.querySelector("#inputfield");
    const messagesList = document.querySelector(".chatbox");
    const chatForm = document.querySelector("form.user-input");

    // Function to load chat history from the server
    function loadChatHistory() {
        fetch('api-backend/chatbot-backend.php', {
            method: 'GET',
        })
            .then(response => response.json())
            .then(data => {
                // Display chat history on the page one message at a time
                displayChatHistory(data.history);
            })
            .catch(error => console.error('Fejl ved indlæsning af chat historie:', error));
    }

    // Load chat history when the page loads
    loadChatHistory();

    chatForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const userInput = inputField.value;

        if (userInput === '') {
            return;
        }


        // Append user's input to chatbox
        appendMessage(userInput, 'sent');

        // Få data ud fra form elementet
        const formData = new FormData(chatForm);
        inputField.value = '';

        // Send user input to the server
        fetch('api-backend/chatbot-backend.php', {
            method: 'POST',
            body: formData,
        })
            .then(response => response.json())
            .then(data => {
                // Wait for a short delay before appending chatbot's response
                setTimeout(() => {
                    appendMessage(data.response, 'received');
                }, 500); // Adjust the delay as needed
            })
            .catch(error => console.error('Fejl ved chatbot-forespørgsel:', error));

    });

    // Function to display chat history one message at a time
    function displayChatHistory(history) {
        history.forEach(({ answer, question }) => {
            appendMessage(question, 'sent');
            appendMessage(answer, 'received');
        });

    }

    // Function to append a message to chatbox
    function appendMessage(messageText, messageType) {
        const messageElement = document.createElement('li');
        messageElement.className = `message ${messageType}`;
        messageElement.textContent = messageText;
        messagesList.appendChild(messageElement);
        // Scroll ned til den sidste besked
        messageElement.scrollIntoView();
    }
});




// Get the input field and CharacterCount paragraph using querySelector
const inputfield = document.querySelector("#inputfield");
const CharacterCount = document.querySelector("#CharacterCount");

// Add an event listener to the input field listening for input events
inputfield.addEventListener("input", opdaterCharacterCount);

// Function to update the CharacterCount
function opdaterCharacterCount() {
    // Get the length of the text in the input field
    const textLength = inputfield.value.length;

    // Update the text in the CharacterCount paragraph
    CharacterCount.textContent = `Character count: ${textLength}`;
}