<?php

namespace App\Model\Entity;

use App\Model\Manager\ArticleManager;

class Commentary extends AbstractEntity
{
    private string $content;
    private User $author;
    private Article $article;

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Commentary
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Commentary
     */
    public function setAuthor(User $author): self
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle(): Article
    {
        return $this->article;
    }

    /**
     * @param Article $article
     * @return Commentary
     */
    public function setArticle(Article $article): self
    {
        $this->article = $article;
        return $this;
    }




}