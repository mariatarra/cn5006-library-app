<?php
require "includes/db.php";
/**
 * Checks the registration data on the server.
 *
 * @param string $username The username
 * @param string $email    The email address
 * @param string $password The password
 * @param string $role     The chosen role id ("1" = Member, "2" = Librarian)
 * @param string $code     The special registration code
 * @return array List of error messages (empty if everything is valid)
 */
function validateRegistration($username, $email, $password, $role, $code)
{
    $errors = [];
    $codes = ["1" => "MEMB2026", "2" => "LIBR2026"];

    if ($username === "") {
        $errors[] = "Username is required.";
    }

    if ($email === "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email is not valid.";
    }

    if ($password === "") {
        $errors[] = "Password is required.";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters.";
    }

    if ($role !== "1" && $role !== "2") {
        $errors[] = "Please select a role.";
    }

    if ($code === "") {
        $errors[] = "Registration code is required.";
    } elseif (isset($codes[$role]) && $code !== $codes[$role]) {
        $errors[] = "Invalid registration code.";
    }

    return $errors;
}
/**
 * Saves a new user in the database. The password is stored as a hash.
 *
 * @param mysqli $conn     The database connection
 * @param string $username The username
 * @param string $email    The email address
 * @param string $password The password (plain text, hashed here)
 * @param int    $roleId   The role id (1 = Member, 2 = Librarian)
 * @return string Empty if the user was saved, otherwise an error message
 */
function saveUser($conn, $username, $email, $password, $roleId)
{
    // Check that the username and email are not already used
    $stmt = mysqli_prepare($conn, "SELECT user_id FROM users WHERE username = ? OR email = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return "Username or email is already registered.";
    }
    mysqli_stmt_close($stmt);

    // Hash the password and insert the new user
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $hash, $roleId);
    $saved = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$saved) {
        return "Registration failed. Please try again.";
    }

    return "";
}
$errors = [];
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $role = $_POST["role"] ?? "";
    $code = trim($_POST["code"] ?? "");

    $errors = validateRegistration($username, $email, $password, $role, $code);

           if (empty($errors)) {
           $conn = getConnection();
           $saveError = saveUser($conn, $username, $email, $password, (int)$role);
           mysqli_close($conn);

           if ($saveError === "") {
               $message = "Registration successful. You can now log in.";
           } else {
               $errors[] = $saveError;
           }
       }
}
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

    <div id="errorMessages"><?php echo implode("<br>", $errors); ?></div>
<p><?php echo $message; ?></p>

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