<?php


namespace MyProject\Models\Articles\Comments;

use http\Exception\InvalidArgumentException;
use MyProject\Models\ActiveRecordEntity;
use MyProject\Models\Users\User;

class Comment extends ActiveRecordEntity
{

    protected $text;
    protected $authorId;
    protected $createdAt;
    protected $articleId;

    protected static function getTableName(): string
    {
        // TODO: Implement getTableName() method.
        return 'comments';
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getNick(): string
    {
        return User::getById($this->authorId)->getNickname();
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return mixed
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param mixed $text
     */
    public function setText($text): void
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getArticleId()
    {
        return $this->articleId;
    }


    /**
     * @param mixed $authorId
     */
    public function setAuthorId($authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @param mixed $articleId
     */
    public function setArticleId($articleId): void
    {
        $this->articleId = $articleId;
    }

    public static function add(int $userId)
    {
        if (mb_strlen($_POST['text']) < 4) {
            throw new \MyProject\Exceptions\InvalidArgumentException('Текст комментария должен быть не меньше 4 символов');
        }
        $comment = new Comment();
        $comment->setArticleId($_POST['articleId']);
        $comment->setAuthorId($userId);
        $comment->setText($_POST['text']);
        $comment->save();
        return $comment;
    }

    public function update(array $fields): Comment
    {
        if (mb_strlen($fields['text']) < 4) {
            throw new \MyProject\Exceptions\InvalidArgumentException('Текст комментария должен быть не меньше 4 символов');
        }
        if (empty($fields['text'])) {
            throw new InvalidArgumentException('Не передан текст комментария');
        }
        $this->setCreatedAt(date("Y-m-d H:i:s"));
        $this->setText($fields['text']);
        $this->save();
        return $this;
    }

}