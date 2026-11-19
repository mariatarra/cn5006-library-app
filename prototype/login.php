<?php
session_start();
require "includes/db.php";

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

/**
 * Finds the user by email and checks the password against the stored hash.
 *
 * @param mysqli $conn     The database connection
 * @param string $email    The email address
 * @param string $password The password (plain text)
 * @return array|null The user's user_id, username and role_id, or null if the login is wrong
 */
function checkCredentials($conn, $email, $password)
{
    $stmt = mysqli_prepare($conn, "SELECT user_id, username, password, role_id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $userId, $username, $hash, $roleId);

    $user = null;

    if (mysqli_stmt_fetch($stmt) && password_verify($password, $hash)) {
        $user = [
            "user_id" => $userId,
            "username" => $username,
            "role_id" => $roleId
        ];
    }

    mysqli_stmt_close($stmt);

    return $user;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $errors = validateLogin($email, $password);

    if (empty($errors)) {
        $conn = getConnection();
        $user = checkCredentials($conn, $email, $password);
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