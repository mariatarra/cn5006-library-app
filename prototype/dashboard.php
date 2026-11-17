<?php
// Temporary version: only shows that the session works.
// The real dashboard (menus, access control) is built in a later step.
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Library</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>Username: <?php echo htmlspecialchars($_SESSION["username"] ?? ""); ?></p>
    <p>User ID: <?php echo $_SESSION["user_id"] ?? ""; ?></p>
    <p>Role ID: <?php echo $_SESSION["role_id"] ?? ""; ?></p>
    <p><a href="logout.php">Logout</a></p>
</body>
</html>