<?php include __DIR__ . '/headerAdmin.php';
$articleView = empty($_POST['articleView']) ? -1 : $_POST['articleView'];
$articleText = empty($_POST ['articleText']) ? -1 : $_POST['articleText'];
if ($articleText < 0) {
    $button = 'Все';
    $zagol = 'Последние';
} else {
    $button = 'Последние';
    $zagol = 'Все';
}
?>
    <h3><?= $zagol ?> статьи:</h3>
<?php foreach ($articles as $article) :
    $rightNow = strtotime(date("Y-m-d H:i:s"),);
    $createdAt = strtotime($article->getCreatedAt());
    if ($articleView > 0) $createdAt = $rightNow;
    if (($rightNow - $createdAt) > (86400 * 3)) {
        continue;
    } ?>
    <h4><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h4>
    <p><?= $article->getShortText(100) ?></p>
    <a href="/articles/<?= $article->getId() ?>/edit">Редактировать</a> ||
    <a href="/articles/<?= $article->getId() ?>/delete">Удалить</a>
    <hr>
<?php endforeach; ?>
    <form action="/admin/view" method="post">
        <input type="hidden" name="articleText" value="<?= $articleText * (-1) ?>">
        <input type="hidden" name="articleView" value="<?= $articleView * (-1) ?>">
        <input type="submit" value="<?= $button ?> статьи">
    </form>
    <hr size="4">
<?php
    $commentView = empty($_POST['commentView']) ? -1 : $_POST['commentView'];
    $commentText = empty($_POST ['commentText']) ? -1 : $_POST['commentText'];
    if ($commentText < 0) {
    $button = 'Все';
    $zagol = 'Последние';
    } else {
    $button = 'Последние';
    $zagol = 'Все';
    }
    ?>
    <h3><?= $zagol ?> комментарии:</h3>
<?php foreach ($comments as $comment):
    $createdAt = strtotime($comment->getCreatedAt());
    if ($commentView > 0) $createdAt = $rightNow;
    if (($rightNow - $createdAt) > (86400 * 3)) {
        continue;
    }
    $article = \MyProject\Models\Articles\Article::findOneByColumn('id', $comment->getArticleId()) ?>
    <h4><a href="/articles/<?= $article->getId() ?>"><?= $article->getName() ?></a></h4>
    <p><?= $comment->getNick() ?>
        <em><?= $comment->getCreatedAt() ?></em></p>
    <p><?= $comment->getText() ?></p>
    <a href="/comments/<?= $comment->getArticleId() ?>/edit">Редактировать</a> ||
    <a href="/comments/<?= $comment->getId() ?>/delete">Удалить</a>
    <hr>
<?php endforeach; ?>
    <form action="/admin/view" method="post">
        <input type="hidden" name="commentText" value="<?= $commentText * (-1) ?>">
        <input type="hidden" name="commentView" value="<?= $commentView * (-1) ?>">
        <input type="submit" value="<?= $button ?> комметарии">
    </form>
<?php include __DIR__ . '/footerAdmin.php'; ?>