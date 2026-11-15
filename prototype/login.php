<?php
// Login page: shows the login form.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Library</title>
</head>
<body>
    <h1>Login</h1>

    <div id="errorMessages"></div>

    <form id="loginForm" method="post" action="login.php" novalidate>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email"><br><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password"><br><br>

        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register</a></p>

    <script src="js/login.js"></script>
</body>
</html>