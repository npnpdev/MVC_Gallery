<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Zapisane zdjęcia</title>
    </head>
    <body>
        <form method=post>
            <?php if (count($images)): ?>
                <?php foreach ($images as $image): ?>
                    <a href="show?id=<?= $image['id'] ?>" target="_blank">
                        <img src="<?= $image['path'] ?>">
                    </a>
                    <p><input type='checkbox' name=<?=$image['id']?>></input></p>
                <?php endforeach ?>
            <button type='submit'>Usuń zaznaczone z zapamiętanych</button>
        </form>
        <?php else: ?>
            Brak zapisanych zdjęć
        <?php endif ?>
        <?php include_once('partial/pagination_view.php')?>
    </body>
</html>