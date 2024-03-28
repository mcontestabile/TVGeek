<?php
// Effettua la connessione al tuo database
$conn = mysqli_connect('localhost', 'username', 'password', 'database_name');

// Recupera i dati delle scelte dell'utente dal payload della richiesta POST
$userChoices = json_decode(file_get_contents('php://input'), true);

// Costruisci la query finale basata sulle scelte dell'utente
$query = "SELECT * FROM all_movies_details_cleaned WHERE ";
foreach ($userChoices as $attribute => $values) {
    $escapedValues = array_map(function($value) use ($conn) {
        return mysqli_real_escape_string($conn, $value);
    }, $values);
    $inValues = "'" . implode("','", $escapedValues) . "'";
    $query .= "$attribute IN ($inValues) AND ";
}
$query = rtrim($query, 'AND ');

// Esegui la query finale
$result = mysqli_query($conn, $query);

// Crea un array per i risultati
$movies = array();
while ($row = mysqli_fetch_assoc($result)) {
    $movies[] = $row;
}

// Restituisci i risultati come una risposta JSON
header('Content-Type: application/json');
echo json_encode($movies);

// Chiudi la connessione al database
mysqli_close($conn);
?>
