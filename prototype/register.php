<?php
require "includes/db.php";
require "includes/User.php";
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
           $user = new User($conn);

           if ($user->exists($username, $email)) {
               $errors[] = "Username or email is already registered.";
           } elseif (!$user->create($username, $email, $password, (int)$role)) {
               $errors[] = "Registration failed. Please try again.";
           } else {
               $message = "Registration successful. You can now log in.";
           }

           mysqli_close($conn);
       }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Library</title>
        <link rel="stylesheet" href="css/style.css">
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