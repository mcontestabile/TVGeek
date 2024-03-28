<?php
/* Credenizali del database. Si ritiene che si stia usando un server MySQL con impostazioni di default (user 'root' e no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'TG');
 
/* Tentativo di connessione */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

$config = array(
    'password' => '5p3r0B4574.',
    'API_KEY' => 'AIzaSyDh186PjtC91Qd7tgs1akulEPq_z7nxr0s'
);

// Controllo della connessione
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>