<?php include __DIR__ . '/headerAdmin.php'; ?>
<h2></h2>
<table border="1" style="border-collapse: collapse">
    <caption><h4>Редактирование пользователей</h4></caption>
    <tr>
        <th>Ник</th>
        <th>Роль</th>
        <th>Почта</th>
        <th>Подтвержден</th>
        <th>Редактирование</th>
    </tr>
    <?php foreach ($users as $user1) : ?>
        <tr>
            <td><?= $user1->getNickname() ?></td>
            <td><?= $user1->getRole() ?></td>
            <td><?= $user1->getEmail() ?></td>
            <td><?= $user1->isConfirmed() ?></td>
            <td><a href="/users/<?= $user1->getId() ?>/edit">Сменить роль</a> ||
                <a href="/users/<?= $user1->getId() ?>/delete">Удалить</a></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php include __DIR__ . '/footerAdmin.php'; ?>
