<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit;
}

// Buffer overflow protection
$nama     = substr(trim($_POST["nama"]     ?? ""), 0, 64);
$komentar = substr(trim($_POST["komentar"] ?? ""), 0, 500);

if ($nama === "" || $komentar === "") {
    die("Nama dan komentar tidak boleh kosong. <a href='../login.php'>Kembali</a>");
}

// XSS protection
$nama     = htmlspecialchars($nama,     ENT_QUOTES, "UTF-8");
$komentar = htmlspecialchars($komentar, ENT_QUOTES, "UTF-8");

// SQL injection protection - prepared statement
$stmt = $conn->prepare("INSERT INTO komentar (nama, komentar) VALUES (?, ?)");
$stmt->bind_param("ss", $nama, $komentar);

if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../login.php");
    exit;
} else {
    die("Gagal menyimpan komentar.");
}
?>
