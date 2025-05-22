<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Logowanie</title>
    </head>
    <body>
        <?= $info ?>
        <?php if ($info !== "Zalogowano pomyślnie!"): ?>
            <h2>Logowanie</h2>
            <form method="post">
                <label for="login">Login:</label><br>
                <input type="text" id="login" name="login" required><br>
                
                <label for="password">Hasło:</label><br>
                <input type="password" id="password" name="password" required><br>
                
                <input type="submit" value="Zaloguj">
            </form>
            <p><a href="register">Zarejestruj się</a></p>
        <?php endif; ?>
    </body>
</html>
