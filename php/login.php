<?php
session_start();
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit;
}

// Brute force protection - maksimal 5 percobaan dalam 5 menit
if (!isset($_SESSION["login_attempts"])) {
    $_SESSION["login_attempts"] = 0;
    $_SESSION["login_time"]     = time();
}

if (time() - $_SESSION["login_time"] > 300) {
    $_SESSION["login_attempts"] = 0;
    $_SESSION["login_time"]     = time();
}

if ($_SESSION["login_attempts"] >= 5) {
    $sisa = 300 - (time() - $_SESSION["login_time"]);
    die("Terlalu banyak percobaan login. Coba lagi dalam $sisa detik. <a href='../login.php'>Kembali</a>");
}

// Buffer overflow protection
$username = substr(trim($_POST["username"] ?? ""), 0, 64);
$password = substr(trim($_POST["password"] ?? ""), 0, 128);

if ($username === "" || $password === "") {
    die("Username dan password tidak boleh kosong. <a href='../login.php'>Kembali</a>");
}

// SQL injection protection - prepared statement
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Hash + salt verification dengan bcrypt
    if (password_verify($password, $row["password"])) {
        $_SESSION["login_attempts"] = 0;
        $_SESSION["user_id"]        = $row["id"];
        $_SESSION["username"]       = $row["username"];

        $stmt->close();
        $conn->close();
        header("Location: ../login.php");
        exit;
    }
}

// Login gagal - tambah counter brute force
$_SESSION["login_attempts"]++;

$stmt->close();
$conn->close();

die("Username atau password salah. Percobaan ke-" . $_SESSION["login_attempts"] . "/5. <a href='../login.php'>Kembali</a>");
?>
