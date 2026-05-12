<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../register.php");
    exit;
}

// Buffer overflow protection
$username = substr(trim($_POST["username"] ?? ""), 0, 32);
$password = substr(trim($_POST["password"] ?? ""), 0, 64);

if ($username === "" || $password === "") {
    die("Username dan password tidak boleh kosong. <a href='../register.php'>Kembali</a>");
}

// Cek username sudah ada (SQL injection protection - prepared statement)
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->get_result()->num_rows > 0 && die("Username sudah digunakan. <a href='../register.php'>Kembali</a>");
$stmt->close();

// Hash password dengan bcrypt (hash + salt)
$hash = password_hash($password, PASSWORD_BCRYPT);

// Simpan user baru
$stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
$stmt->bind_param("ss", $username, $hash);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../login.php?register=sukses");
    exit;
} else {
    die("Gagal mendaftar. <a href='../register.php'>Kembali</a>");
}
?>
