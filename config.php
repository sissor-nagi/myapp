<?php

$host = "localhost"; // défaut Apache

// Si on est dans Docker → utiliser mysql
if (getenv('DB_HOST')) {
    $host = getenv('DB_HOST');
}

$user = "appuser";
$pass = "User@123Secure";
$db   = "myapp";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}
?>
