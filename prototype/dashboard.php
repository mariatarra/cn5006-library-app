<?php
require "includes/auth.php";
require "includes/menu.php";
requireLogin();

$roleName = ($_SESSION['role_id'] == ROLE_LIBRARIAN) ? "Librarian" : "Member";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - Library</title>
</head>
<body>
    <?php renderMenu(); ?>

    <h1>Dashboard</h1>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>.</p>
    <p>Your role: <?php echo $roleName; ?></p>
</body>
</html>