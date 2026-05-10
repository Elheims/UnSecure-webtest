<?php
session_start();
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.html");
    exit;
}

// Ambil dan batasi panjang input (buffer overflow protection)
$username = substr(trim($_POST["username"] ?? ""), 0, 64);
$password = substr(trim($_POST["password"] ?? ""), 0, 128);

if ($username === "" || $password === "") {
    die("Username dan password tidak boleh kosong.");
}

// Prepared statement (SQL injection protection)
$stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    // Verifikasi password dengan bcrypt (hash + salt otomatis)
    if (password_verify($password, $row["password"])) {
        $_SESSION["user_id"]  = $row["id"];
        $_SESSION["username"] = $row["username"];

        header("Location: ../login.html");
        exit;
    }
}

// Login gagal
$stmt->close();
$conn->close();

die("Username atau password salah. <a href='../login.html'>Kembali</a>");
?>
