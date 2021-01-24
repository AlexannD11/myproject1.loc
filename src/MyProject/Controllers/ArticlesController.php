<?php


namespace MyProject\Controllers;

use MyProject\Exceptions\{ForbiddenException, InvalidArgumentException, NotFoundException, UnauthorizedException};
use MyProject\Models\Articles\Article;
use MyProject\Models\Articles\Comments\Comment;

class ArticlesController extends AbstractController
{
    /**
     * @param int $articleId
     */
    public function view(int $articleId)
    {
        $article = Article::getById($articleId);
        if ($article === null) {
            throw new NotFoundException('Не найдена такая статья');
        }
        $this->view->setVar('articleId',$articleId);
        $comments = Comment::findAllByColumn('article_id', $articleId);
        $this->view->renderHtml('articles/view.php', [
            'article' => $article, 'comments' => $comments
        ]);
    }

    /**
     * @param int $articleId
     */
    public function edit(int $articleId): void
    {
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException('Не найдена такая статья');
        }
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Для редактирования статьи необходимы права администратора');
        }
        if (!empty($_POST)) {
            try {
                $article->updateFromArray($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/edit.php', ['error' => $e->getMessage(), 'article' => $article]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/edit.php', ['article' => $article]);
    }

    public function add(): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Для добавления статьи необходимы права администратора');
        }

        if (!empty($_POST)) {
            try {
                $article = Article::createFromArray($_POST, $this->user);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/add.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $article->getId(), true, 302);
            exit();
        }

        $this->view->renderHtml('articles/add.php');
    }

    public function delete(int $articleId): void
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Для удаления статьи необходимы права администратора');
        }
        $article = Article::getById($articleId);

        if ($article === null) {
            throw new NotFoundException('Не найдена такая статья');
        }
        $article->delete();
        header('Location: /admin/view');
    }
}