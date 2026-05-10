<?php
require "config.php";

// Generate hash bcrypt untuk password admin
$password  = "admin123";
$hash      = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = 'admin'");
$stmt->bind_param("s", $hash);

if ($stmt->execute()) {
    echo "Setup berhasil.<br>";
    echo "Username: admin<br>";
    echo "Password: $password<br>";
    echo "Hash: $hash<br>";
} else {
    echo "Setup gagal: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
