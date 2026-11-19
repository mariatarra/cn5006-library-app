<?php
session_start();
require "includes/db.php";
require "includes/User.php";

/**
 * Checks the login data on the server.
 *
 * @param string $email    The email address
 * @param string $password The password
 * @return array List of error messages (empty if everything is valid)
 */
function validateLogin($email, $password)
{
    $errors = [];

    if ($email === "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid.";
    }

    if ($password === "") {
        $errors[] = "Password is required.";
    }

    return $errors;
}



$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $errors = validateLogin($email, $password);

    if (empty($errors)) {
        $conn = getConnection();
                $userModel = new User($conn);
        $user = $userModel->checkCredentials($email, $password);
        mysqli_close($conn);

        if ($user === null) {
            $errors[] = "Invalid email or password.";
        } else {
            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role_id"] = $user["role_id"];
            header("Location: dashboard.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Library</title>
        <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Login</h1>

    <div id="errorMessages">
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>

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