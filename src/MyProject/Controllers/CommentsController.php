<?php


namespace MyProject\Controllers;

use MyProject\Exceptions\{ForbiddenException, InvalidArgumentException, NotFoundException, UnauthorizedException};
use MyProject\Models\Articles\Article;
use MyProject\Models\Articles\Comments\Comment;

class CommentsController extends AbstractController
{

    public function add(): void
    {
        $articleId = $_POST['articleId'];
        $this->article = Article::getById($articleId);
        $this->comments = Comment::findAllByColumn('article_id', $articleId);
        $this->view->setVar('article', $this->article);
        $this->view->setVar('comments', $this->comments);
        if ($this->user === null) {
            throw new UnauthorizedException();
        }

        if (!empty($_POST)) {
            try {
                $comment = Comment::add($this->user->getId());
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('articles/view.php', ['error' => $e->getMessage()]);
                return;
            }

            header('Location: /articles/' . $this->article->getId() . '#comment' . $comment->getId(), true, 302);
            exit();
        }
        $this->view->renderHtml('articles/view.php');
    }

    public function edit($commentId): void
    {
        $comment = Comment::getById($commentId);
        $article = Article::getById($comment->getArticleId());
        if ($comment === null) {
            throw new NotFoundException('Не найден комментарий');
        }
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if (!($this->user->isAdmin() || $this->user->getId() == $comment->getAuthorId())) {
            throw new ForbiddenException('Редактировать комментарии может автор или администратор',
                ['user' => $this->user]);
        }
        if (!empty($_POST)) {
             try {
                 $comment->update($_POST);
             } catch (InvalidArgumentException $e) {
                 $this->view->renderHtml('articles/comments/edit.php', ['error' => $e->getMessage(),
                     'comment' => $comment,'article'=>$article]);
                 return;
             }

             header('Location: /articles/' . $article->getId() . '#comment' . $comment->getId(), true, 302);
             exit();
         }

        $this->view->renderHtml('articles/comments/edit.php', ['comment' => $comment]);
    }
    public function delete($commentId)
    {
        if ($this->user === null) {
            throw new UnauthorizedException();
        }
        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Для удаления комментария необходимы права администратора');
        }
        $comment = Comment::getById($commentId);

        if ($comment === null) {
            throw new NotFoundException('Не найден такой комментарий');
        }

        $comment->delete();
        header('Location: /admin/view');
    }
}