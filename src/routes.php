<?php
return [
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~^users/login~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^users/(\d+)/edit~' => [\MyProject\Controllers\UsersController::class, 'edit'],
    '~^users/(\d+)/delete~' => [\MyProject\Controllers\UsersController::class, 'delete'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^comments/(\d+)/delete$~' => [\MyProject\Controllers\CommentsController::class, 'delete'],
    '~^admin/view$~' => [\MyProject\Controllers\AdminController::class, 'view'],
    '~^admin/users$~' => [\MyProject\Controllers\AdminController::class, 'usersView'],
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
];