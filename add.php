<?php
include "config.php";

$name = $_POST['name'];
$email = $_POST['email'];

$conn->query("INSERT INTO students (name, email) VALUES ('$name', '$email')");

header("Location: index.php");
?>
