<?php
// Public home page of the library.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Municipal Library</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Municipal Library</h1>
        <nav>
            <a href="login.php">Login</a> |
            <a href="register.php">Register</a>
        </nav>
    </header>

        <main>
        <section>
            <h2>About the library</h2>
            <p>The Municipal Library has been part of the city for many years. Our shelves hold novels, children's books, school textbooks, history, science and books about our own area. We also keep a quiet reading room that is open to everyone. Members can borrow books to take home, reserve a title that is already out, and ask our librarians for help finding what they need.</p>
            <img src="pictures/library1.jpg" alt="Inside the library">
        </section>

        <section>
            <h2>Visit us</h2>
            <p>Address: 12 Eleftherias Square, Athens</p>
            <p>Opening hours: Monday to Friday from 9:00 to 20:00, Saturday from 10:00 to 14:00. We are closed on Sundays and public holidays.</p>
            <p>To join, click Register, choose your role and enter the registration code you were given by the library. After that you can log in and use your account.</p>
            <img src="pictures/library2.jpg" alt="Library bookshelves">
        </section>

        <section>
            <h2>Where to find us</h2>
            <div id="map"></div>
        </section>
    </main>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="js/map.js"></script>
</body>
</html>