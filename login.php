<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>SecureWeb</title>
</head>
<body>

    <?php if (isset($_SESSION["username"])): ?>
        <p style="color:green;"><b>Login berhasil sebagai: <?= $_SESSION["username"] ?></b></p>
        <form action="php/logout.php" method="POST">
            <input type="submit" value="Logout">
        </form>
        <hr>
    <?php endif; ?>

    <h2>Login</h2>

    <form action="php/login.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" maxlength="32" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" maxlength="64" required><br><br>

        <input type="submit" value="Login">
    </form>
    <p><a href="register.php">Register di sini</a></p>

    <hr>

    <h2>Komentar</h2>

    <form action="php/komentar.php" method="POST">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" maxlength="64"><br><br>

        <label for="komentar">Komentar:</label><br>
        <textarea id="komentar" name="komentar" rows="4" cols="50" maxlength="500"></textarea><br><br>

        <input type="submit" value="Kirim Komentar">
    </form>

    <hr>

    <h3>Daftar Komentar</h3>
    <?php
    require "php/config.php";
    $result = $conn->query("SELECT nama, komentar, created_at FROM komentar ORDER BY created_at DESC");
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p><b>" . $row["nama"] . "</b> <small>(" . $row["created_at"] . ")</small><br>";
            echo $row["komentar"] . "</p><hr>";
        }
    } else {
        echo "<p>Belum ada komentar.</p>";
    }
    $conn->close();
    ?>

</body>
</html>
