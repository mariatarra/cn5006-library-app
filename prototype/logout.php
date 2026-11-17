<?php
/**
 * Logs the user out: destroys the session and returns to the public page.
 */
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit;