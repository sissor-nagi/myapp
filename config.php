<?php
$host = "localhost";   // IMPORTANT
$user = "appuser";
$pass = "User@123Secure";
$db   = "myapp";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erreur de connexion: " . $conn->connect_error);
}
?>
