<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: waccount.html");
    exit;
}

// Include config file
require_once "config.php";

// Recupera l'attributo dalla query string
$attribute = $_GET['attribute'];

// Esegui la query per ottenere i valori univoci per l'attributo
$query = "SELECT DISTINCT $attribute FROM all_movies_details_cleaned";
$result = mysqli_query($conn, $query);

// Crea un array per i risultati
$values = array();
while ($row = mysqli_fetch_assoc($result)) {
    $values[] = $row[$attribute];
}

// Restituisci i valori come una risposta JSON
header('Content-Type: application/json');
echo json_encode($values);

// Chiudi la connessione al database
mysqli_close($conn);
?>
