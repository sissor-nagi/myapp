<?php
include "config.php";

session_start();

$username = $_POST['username'];
$password = md5($_POST['password']);

$stmt = $conn->prepare("SELECT * FROM admins WHERE username=? AND password=?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $_SESSION['admin'] = $username;
    header("Location: index.php");
} else {
    echo "Login incorrect";
}
?>
