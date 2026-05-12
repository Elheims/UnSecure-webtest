<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register – SecureWeb</title>
</head>
<body>

    <h2>Register</h2>

    <form action="php/register.php" method="POST">
        <label for="username">Username:</label><br>
        <input type="text" id="username" name="username" maxlength="32" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" id="password" name="password" maxlength="64" required><br><br>

        <input type="submit" value="Register">
    </form>

    <p><a href="login.php">Login di sini</a></p>

</body>
</html>
