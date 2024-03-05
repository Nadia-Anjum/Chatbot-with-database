<?php
include("MySQL.php");
require_once 'history.php'; // Include the history files

// Initialize user input and chatbot response
$myInput = isset($_POST['myInput']) ? $_POST['myInput'] : '';
$chatbotResponse = "";

if (!empty($myInput)) {
    global $mySQL;

    // Initiate quure
    $query = "SELECT answers.answer, answers.answer_id_PK
              FROM answers 
              JOIN keywords ON keywords.answer_FK = answers.answer_id_PK
              ";

    // Split user input into words
    // fx "hej med dig" becomes ["hej", "med", "dig"]
    $words = explode(" ", $myInput);

    // Fjerner og gemmer første keyword fra arrayet
    $firstKeyword = array_shift($words);

    // Build where's for the query. First keyword uses "WHERE" and the rest uses "OR"
    $query .= "WHERE keywords.keyword = '$firstKeyword' ";

    // Loop through the rest of the keywords
    foreach ($words as $kw) {
        $query .= "OR keywords.keyword = '$kw' ";
    }

    // her sender vi forespørgslen til databasen
    $result = $mySQL->query($query);

    // Tilføj answers fra SQL query result til et array
    $answers = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $answers[] = $row;
        }
    }

    // Hvis der er flere end 0 svar, så vælg første svar
    if (count($answers) > 0) {
        $chatbotResponse = $answers[0]['answer'];
        $chatbotResponseId = $answers[0]['answer_id_PK'];
    } else {
        // TODO: Få default beskeden ud af databasen på id 0, istedet for hardcoded.
        $chatbotResponse = "Jeg forstaar ikke hvad du mener";
        $chatbotResponseId = 0;
    }


    // Add user input and chatbot response to the chat history
    addToChatHistory($myInput, $chatbotResponseId);
    // skal rettes til så den snakker med databsen
}

// her returnerer vi chatbot response i JSON
$responseData = [
    'response' => $chatbotResponse,
    'history' => getChatHistory() // her får vi chathistorikken fra history.php-filen
];

// Koden sætter headeren for HTTP-svaret til at være JSON-format, og derefter bruger 
// den funktionen json_encode() til at konvertere $responseData-arrayet til JSON-format. Til sidst 
// bliver JSON-dataene sendt tilbage til klienten som svar på HTTP-anmodningen.
header('Content-Type: application/json');
echo json_encode($responseData);
