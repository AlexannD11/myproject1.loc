<?php


namespace MyProject\Controllers;


use MyProject\Exceptions\ForbiddenException;
use MyProject\Exceptions\UnauthorizedException;
use MyProject\Models\Articles\Article;
use MyProject\Models\Articles\Comments\Comment;
use MyProject\Models\Users\User;

class AdminController extends AbstractController
{
    public function __construct()
    {
        parent::__construct();
        $articles = Article::findAll();
        $users=User::findAll();
        $comments=Comment::findAll();
        $this->view->setVar('articles',$articles);
        $this->view->setVar('users',$users);
        $this->view->setVar('comments',$comments);
    }

    public function view()
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Эта страница только для администраторов');
        }
        $this->view->renderHtml('admin/view.php', ['title' => 'Панель администратора']);
    }
    public function usersView()
    {
        $this->view->renderHtml('admin/viewUsers.php', ['title' => 'Панель администратора']);
    }
}