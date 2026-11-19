<?php
/**
 * Handles the users table: duplicate check, registration and login check.
 */
class User
{
    /** @var mysqli The database connection */
    private $conn;

    /**
     * Creates the object with an open database connection.
     *
     * @param mysqli $conn The database connection
     */
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Checks if a username or an email is already registered.
     *
     * @param string $username The username
     * @param string $email    The email address
     * @return bool True if one of them is already used
     */
    public function exists($username, $email)
    {
        $stmt = mysqli_prepare($this->conn, "SELECT user_id FROM users WHERE username = ? OR email = ?");
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        $found = mysqli_stmt_num_rows($stmt) > 0;

        mysqli_stmt_close($stmt);

        return $found;
    }

    /**
     * Saves a new user. The password is stored as a hash.
     *
     * @param string $username The username
     * @param string $email    The email address
     * @param string $password The password (plain text, hashed here)
     * @param int    $roleId   The role id (1 = Member, 2 = Librarian)
     * @return bool True if the user was saved
     */
    public function create($username, $email, $password, $roleId)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = mysqli_prepare($this->conn, "INSERT INTO users (username, email, password, role_id) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssi", $username, $email, $hash, $roleId);

        $saved = mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);

        return $saved;
    }

    /**
     * Finds the user by email and checks the password against the stored hash.
     *
     * @param string $email    The email address
     * @param string $password The password (plain text)
     * @return array|null The user's user_id, username and role_id, or null if the login is wrong
     */
    public function checkCredentials($email, $password)
    {
        $stmt = mysqli_prepare($this->conn, "SELECT user_id, username, password, role_id FROM users WHERE email = ?");
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
}