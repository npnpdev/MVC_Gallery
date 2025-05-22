<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Rejestracja</title>
    </head>
    <body>
        <?= $info?>
        <h2>Rejestracja</h2>
        <form method="post">
            <label for="email">Adres e-mail:</label><br>
            <input type="email" id="email" name="email" required><br>
            
            <label for="login">Login:</label><br>
            <input type="text" id="login" name="login" required><br>
            
            <label for="password">Hasło:</label><br>
            <input type="password" id="password" name="password" required><br>
            
            <label for="confirm_password">Powtórz hasło:</label><br>
            <input type="password" id="confirm_password" name="confirm_password" required><br>
            
            <input type="submit" value="Zarejestruj">
        </form>
        <h3>Wymagania dotyczące hasła:</h3>
        <ul>
            <li>Przynajmniej 1 znak specjalny</li>
            <li>Przynajmniej 1 wielka litera</li>
            <li>Przynajmniej 1 cyfra</li>
            <li>Musi mieć przynajmniej długość 8 znaków</li>
        </ul>
    </body>
</html>
