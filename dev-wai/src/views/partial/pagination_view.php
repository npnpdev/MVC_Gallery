<div class="pagination">
    <?php if ($currentPage > 1): ?>
        <a href="?page=<?= ($currentPage - 1) ?>">Poprzednia</a>
    <?php endif ?>

    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>" <?= $currentPage === $i ? 'class="active"' : '' ?>><?= $i ?></a>
    <?php endfor ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?page=<?= ($currentPage + 1) ?>">Następna</a>
    <?php endif ?>
</div>