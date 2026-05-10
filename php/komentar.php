<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.html");
    exit;
}

// Batasi panjang input (buffer overflow protection)
$nama     = substr(trim($_POST["nama"]     ?? ""), 0, 64);
$komentar = substr(trim($_POST["komentar"] ?? ""), 0, 500);

if ($nama === "" || $komentar === "") {
    die("Nama dan komentar tidak boleh kosong. <a href='../login.html'>Kembali</a>");
}

// XSS protection - encode karakter berbahaya
$nama     = htmlspecialchars($nama,     ENT_QUOTES, "UTF-8");
$komentar = htmlspecialchars($komentar, ENT_QUOTES, "UTF-8");

// Prepared statement (SQL injection protection)
$stmt = $conn->prepare("INSERT INTO komentar (nama, komentar) VALUES (?, ?)");
$stmt->bind_param("ss", $nama, $komentar);

if ($stmt->execute()) {
    header("Location: ../login.html?komentar=sukses");
} else {
    die("Gagal menyimpan komentar.");
}

$stmt->close();
$conn->close();
?>
