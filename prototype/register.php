<?php
// Registration page: shows the sign-up form.
// Saving the user is added in a later step.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Library</title>
</head>
<body>
    <h1>Register</h1>

    <div id="errorMessages"></div>

    <form id="registerForm" method="post" action="register.php" novalidate>

        <label for="username">Username</label><br>
        <input type="text" id="username" name="username"><br><br>

        <label for="email">Email</label><br>
        <input type="email" id="email" name="email"><br><br>

        <label for="password">Password</label><br>
        <input type="password" id="password" name="password"><br><br>

        <label for="role">Role</label><br>
        <select id="role" name="role">
            <option value="">-- Select role --</option>
            <option value="1">Member</option>
            <option value="2">Librarian</option>
        </select><br><br>

        <label for="code">Registration code</label><br>
        <input type="text" id="code" name="code"><br><br>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
    <script src="js/register.js"></script>
</body>
</html>