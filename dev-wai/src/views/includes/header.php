<!DOCTYPE html>
<html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }
            
            nav {
                width: 100%;
                background-color: #f0f0f0;
            }

            nav ul {
                list-style-type: none;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: space-between;
            }

            nav ul li {
                margin-right: 20px;
            }

            nav ul li a {
                text-decoration: none;
                color: black;
            }

            nav ul li a:hover {
                color: blue;
            }

        </style>
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="gallery">Galeria zdjęć</a></li>
                <li><a href="upload">Dodaj nowe</a></li>
                <li><a href="saved">Pokaż zapisane</a></li>
                <li><a href="search">Wyszukaj</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout">Wyloguj</a></li>
                <?php else: ?>
                    <li><a href="login">Logowanie</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </body>
</html>