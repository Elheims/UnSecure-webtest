<?php
require "config.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../login.php");
    exit;
}

$nama     = $_POST["nama"];
$komentar = $_POST["komentar"];

// VULNERABLE: tidak ada sanitasi (XSS)
// VULNERABLE: string concatenation langsung ke query (SQL Injection)
$query = "INSERT INTO komentar (nama, komentar) VALUES ('$nama', '$komentar')";

if ($conn->query($query)) {
    header("Location: ../login.php");
    exit;
} else {
    die("Gagal menyimpan komentar.");
}
?>
