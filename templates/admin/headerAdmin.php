<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Мой блог' ?></title>
    <link rel="stylesheet" href="/styles.css">
</head>
<body>
<?php if ($user == null || !$user->isAdmin()) {
    header('Location:/');
} ?>
<table class="layout">
    <tr>
        <td colspan="2" class="header">
            <?= $title ?? 'Мой блог' ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align: right">
            <? if (!empty($user)) { ?>
                Привет, <?= $user->getNickname() ?? '' ?> | <a href="/users/logout">Выйти</a>
            <? } else { ?>
                <a href="/users/login">Войти</a> | <a href="/users/register">Зарегистрироваться</a>
            <? } ?>
        </td>
    </tr>
    <tr>
        <td>