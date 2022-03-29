<?php

namespace App\Model\Manager;

use App\Model\Entity\Article;
use DB_Connect;

class ArticleManager
{
    public const TABLE = "ndmp22_article";

    public static function getAll(): array
    {
        $articles = [];

        $query = DB_Connect::dbConnect()->query("SELECT * FROM " . self::TABLE . " ORDER BY id DESC");

        if ($query) {

            foreach ($query->fetchAll() as $article) {
                $articles[] = (new Article())
                    ->setId($article['id'])
                    ->setTitle($article['title'])
                    ->setResume($article['resume'])
                    ->setAuthor(UserManager::getUserById($article['user_fk']))
                    ->setContent($article['content']);
            }
        }
        return $articles;
    }

    public static function articleExist(int $id)
    {
        $query = DB_Connect::dbConnect()->query("SELECT count(*) as cnt FROM " . self::TABLE . " WHERE id = $id");
        return $query ? $query->fetch()['cnt'] : 0;
    }

    public static function getArticleById(int $id): ?Article
    {
        $query = DB_Connect::dbConnect()->query("SELECT * FROM " . self::TABLE . " WHERE id = $id");
        return $query ? ArticleManager::makeArticle($query->fetch()) : null;
    }

    public static function makeArticle(array $data): Article
    {
        return (new Article())
            ->setId($data['id'])
            ->setResume($data['resume'])
            ->setContent($data['content'])
            ->setAuthor(UserManager::getUserById($data['user_fk']))
            ->setTitle($data['title']);
    }

    public static function createArticle(int $id)
    {
        $stmt = DB_Connect::dbConnect()->prepare("
            INSERT INTO " . self::TABLE . " (title, resume, content, user_fk)
            VALUES (:title, :resume, :content, :user_fk)
        ");

        $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
        $resume = filter_var($_POST['resume'], FILTER_SANITIZE_STRING);
        $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);


        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':resume', $resume);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam('user_fk', $id);

        if ($stmt->execute()) {
            header("Location: /index.php?c=home&f=3");
        } else {
            header("Location: /index.php?c=home&f=4");
        }
    }

    public static function deleteArticle(int $id)
    {
        $query = DB_Connect::dbConnect()->query("
            DELETE FROM ". self::TABLE ." WHERE id = $id
        ");
        if ($query) {
            header("Location: /index.php?c=home&f=5");
        } else {
            header("Location: /index.php?c=home");
        }

    }

    public static function editArticle (int $id, string $title, string $resume, string $content)
    {
        $stmt = DB_Connect::dbConnect()->prepare("
            UPDATE ". self::TABLE ." SET title = :title, resume = :resume, content = :content WHERE id = :id
        ");


        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":resume", $resume);
        $stmt->bindParam(":content", $content);

        $stmt->execute();
    }


}