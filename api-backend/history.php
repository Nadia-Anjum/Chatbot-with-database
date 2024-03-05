<?php 

include("MySQL.php");

function addToChatHistory($userInput, $chatbotResponseId)
{
    // Add user input and chatbot response to the chat history in the messages table
    global $mySQL;
    $query = "INSERT INTO messages (question, answer_FK) VALUES ('$userInput', '$chatbotResponseId')";
    $mySQL->query($query);
}

// her laver vi en funktion der hedder getChatHistory() som returnerer chathistorikken fra databasen
function getChatHistory() {
    global $mySQL;

// her laver vi en forespørgsel til databasen, der henter alle beskeder og svar fra databasen
    $query = "SELECT messages.question, answers.answer
              FROM messages 
              INNER JOIN answers 
              ON messages.answer_FK = answers.answer_id_PK";

// her sender vi forespørgslen til databasen
    $result = $mySQL->query($query);

//  her tjekker vi om 
    if ($result->num_rows > 0) {
        $messages = array();
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row;
        }
        return $messages;
    } else {
        return array();
    }
}

?>