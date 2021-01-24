<?php
include __DIR__ . '/../../header.php';
?>
<h3>Редактирование комментария</h3>
<?php if(!empty($error)): ?>
    <div style="color: red;"><?= $error ?></div>
<?php endif; ?>
<form action="/comments/<?= $comment->getId() ?>/edit" method="post">
    <textarea name="text" id="text" rows="10" cols="80"><?= $_POST['text'] ?? $comment->getText() ?></textarea><br>
    <br>
    <input type="submit" value="Обновить">
</form>
<?php include __DIR__ . '/../../footer.php'; ?>
