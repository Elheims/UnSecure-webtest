<?php
session_start();
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit;
}

$username = $_POST["username"];
$password = $_POST["password"];

// VULNERABLE: string concatenation langsung ke query (SQL Injection)
// VULNERABLE: password dicompare plain text (tidak ada hash/salt)
$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION["user_id"]  = $row["id"];
    $_SESSION["username"] = $row["username"];

    header("Location: ../login.php");
    exit;
}

die("Username atau password salah. <a href='../login.php'>Kembali</a>");
?>
