<?php
/**
 * Shows the navigation menu that matches the role of the logged-in user.
 * Needs includes/auth.php to be loaded first.
 *
 * @return void
 */
function renderMenu()
{
    echo '<nav>';
    echo '<a href="dashboard.php">Dashboard</a> | ';

    if ($_SESSION['role_id'] == ROLE_LIBRARIAN) {
        echo '<a href="librarian_books.php">Manage Books</a> | ';
        echo '<a href="librarian_reservations.php">All Reservations</a> | ';
        echo '<a href="librarian_loans.php">All Loans</a> | ';
    } else {
        echo '<a href="member_books.php">Catalogue</a> | ';
        echo '<a href="member_reservations.php">My Reservations</a> | ';
        echo '<a href="member_loans.php">My Loans</a> | ';
    }

    echo '<a href="logout.php">Logout</a>';
    echo '</nav>';
}