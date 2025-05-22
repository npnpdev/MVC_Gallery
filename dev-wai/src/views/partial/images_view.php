<form method=post>
    <?php if (count($images)): ?>
    <?php foreach ($images as $image): ?>
        <a href="show?id=<?= $image['_id'] ?>" target="_blank">
            <img src="<?= $image['path'] ?>">
        </a>
        <p>Tytuł: <?= $image['title'] ?></p>
        <p>Autor: <?= $image['author'] ?></p>
        <?php if ($image['visibility'] === 'private'): ?>
            <p>Widoczność: <?= $image['visibility'] ?></p>
        <?php endif; ?>
        <?php
            $ids = array_column($saved, 'id'); 
            $checked = in_array($image['_id'], $ids) ? 'checked' : ''; 
        ?>
        <p><input type='checkbox' name=<?=$image['_id']?> <?=$checked?>></input></p>
    <?php endforeach ?>
    <button type='submit'>Zapamiętaj wybrane</button>
</form>
<?php else: ?> Brak zdjęć <?php endif ?>
<?php include_once('pagination_view.php')?>