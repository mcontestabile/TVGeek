<?php
// Inizializzo la sessione.
session_start();
 
// Resetto tutte le session variables.
$_SESSION = array();
 
// "Distruggo" la sessione.
session_destroy();
 
// Reindirizzo l'utente alla login page.
header("location: index.html");
exit;
?>