<?php include __DIR__ . '/../header.php';
if ($user !== null && $user->isAdmin()) :?>
    <a href="/articles/<?= $article->getId() ?>/edit">Редактировать</a>
<? endif; ?>
<h1><?= $article->getName() ?></h1>
<p><?= $article->getParsedText() ?></p>
<p>Автор: <?= $article->getAuthor()->getNickname() ?></p>

<h3>Комментарии</h3>
<?php if ($user !== null) : ?>
    <div class="block2">
        <?php if (!empty($error)): ?>
            <div style="color: red;"><?= $error ?></div>
        <?php endif; ?>
        <form action="/articles/<?= $article->getId() ?>/comments" method="post">
            <label for="text">Добавить комментарий:</label><br>
            <textarea name="text" id="text" rows="5" cols="80"><?= $_POST['text'] ?? '' ?></textarea><br>
            <br>
            <input type="hidden" name="articleId" value="<?= $article->getId() ?>">
            <input type="submit" value="Отправить">
        </form>
    </div>
<?php else: ?>
    Для добавления комментариев нужно <a href="/users/login">войти</a> или <a
            href="/users/register">зарегистрироваться</a>
<?php endif; ?>
<hr>
<?php foreach ($comments as $comment): ?>
    <a id="comment<?= $comment->getId() ?>"></a>
    <p><?= $comment->getNick() ?>
        <em><?= $comment->getCreatedAt() ?></em></p>
    <p><?= $comment->getText() ?></p>
    <? if ($user !== null) :
        if ($user->isAdmin() || $comment->getAuthorId() == $user->getId()) :?>
            <a href="/comments/<?= $comment->getId() ?>/edit">Редактировать</a>
        <?php endif; ?>
    <?php endif; ?>
    <hr>
<? endforeach ?>

<?php include __DIR__ . '/../footer.php'; ?>
