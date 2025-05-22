<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Wgraj zdjęcie</title>
    </head>
    <body>
        <?php foreach ($errors as $error): ?>
            <?= $error ?><br>
        <?php endforeach; ?>

        <form method="post" enctype="multipart/form-data">
            <label for="fileToUpload">Wybierz plik obrazu:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" required><br><br>

            <label for="znak_wodny">Podaj tekst znaku wodnego:</label>
            <input type="text" name="znak_wodny" id="znak_wodny" required><br><br>

            <label for="title">Podaj tytuł:</label>
            <input type="text" name="title" id="title" required><br><br>

            <label for="author">Podaj autora:</label>
            <input type="text" name="author" id="author" value="<?=$user?>" required><br><br>

            <?php if ($user): ?>
                <input type="radio" id="public" name="visibility" value="public" checked>
                <label for="public">Publiczne</label><br>
                <input type="radio" id="private" name="visibility" value="private">
                <label for="private">Prywatne</label><br><br>
            <?php else: ?>
                <input type="hidden" name="visibility" value="public">
            <?php endif; ?>

            <input type="submit" value="Prześlij plik" name="submit"><br>
        </form>
    </body>
</html>
