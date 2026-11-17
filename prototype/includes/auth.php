<?php
/**
 * Access control for the library application.
 * Include this file at the top of every protected page.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROLE_MEMBER', 1);
define('ROLE_LIBRARIAN', 2);

/**
 * Makes sure the user is logged in.
 * Without an active session, the user is sent to the login page.
 *
 * @return void
 */
function requireLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Makes sure the user is logged in and has the required role.
 * With another role, the message "Forbidden Action" is shown.
 *
 * @param int $roleId The role allowed to see the page (ROLE_MEMBER or ROLE_LIBRARIAN)
 * @return void
 */
function requireRole($roleId)
{
    requireLogin();

    if ($_SESSION['role_id'] != $roleId) {
        http_response_code(403);
        echo 'Forbidden Action';
        exit;
    }
}