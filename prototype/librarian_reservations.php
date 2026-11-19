<?php
require "includes/auth.php";
require "includes/menu.php";
requireRole(ROLE_LIBRARIAN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>All Reservations - Library</title>
        <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php renderMenu(); ?>

    <h1>All Reservations</h1>
    <p>This page will be built in Part B.</p>
</body>
</html>