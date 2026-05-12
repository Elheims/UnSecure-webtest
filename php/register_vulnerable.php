<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../register.php");
    exit;
}

$username = $_POST["username"];
$password = $_POST["password"];

// VULNERABLE: string concatenation (SQL Injection)
// VULNERABLE: password disimpan plain text (tidak ada hash)
$query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";

if ($conn->query($query)) {
    header("Location: ../login.php");
    exit;
} else {
    die("Gagal mendaftar: " . $conn->error);
}
?>
