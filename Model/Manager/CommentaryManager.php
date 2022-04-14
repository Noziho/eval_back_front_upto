<?php

namespace App\Model\Manager;

use App\Model\Entity\Article;
use App\Model\Entity\Commentary;
use App\Model\Entity\User;
use DB_Connect;

class CommentaryManager
{
    public const TABLE = "ndmp22_comment";

    public static function getAll(): array
    {
        $comments = [];

        $query = DB_Connect::dbConnect()->query("SELECT * FROM " . self::TABLE . " ORDER BY id DESC");

        if ($query) {
            if (isset($_SESSION['user'])) {

                $user = $_SESSION['user'];
                /* @var User $user */

                foreach ($query->fetchAll() as $comment) {
                    $comments[] = (new Commentary())
                        ->setId($comment['id'])
                        ->setContent($comment['content'])
                        ->setAuthor(UserManager::getUserById($comment['user_fk']))
                        ->setArticle(ArticleManager::getArticleById($comment['article_fk']));
                }
            }
        }
        return $comments;
    }

    public static function addComment(int $id)
    {
        $stmt = DB_Connect::dbConnect()->prepare("
            INSERT INTO " . self::TABLE . " (content, user_fk, article_fk)
            VALUES (:content, :user_fk, :article_fk)
        ");


        if (isset($_SESSION['user'])) {

            $user = $_SESSION['user'];
            /* @var User $user */

            $user_fk = $user->getId();
        }

        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':user_fk', $user_fk);
        $stmt->bindParam(':article_fk', $id);

        if ($stmt->execute()) {
            header("Location: /index.php?c=article&a=show-article&id={$id}");
        }
    }

    public static function getCommentsByArticle(Article $article): array
    {
        $comments = [];

        $query = DB_Connect::dbConnect()->query("SELECT *FROM " . self::TABLE . " WHERE article_fk = " . $article->getId() ." ORDER BY id DESC "
        );

        if ($query) {
            foreach ($query->fetchAll() as $commentData) {
                $comments[] = (new Commentary())
                    ->setId($commentData['id'])
                    ->setContent($commentData['content'])
                    ->setAuthor(UserManager::getUserById($commentData['user_fk']))
                    ->setArticle(ArticleManager::getArticleById($commentData['article_fk']));
            }
        }

        return $comments;
    }

    public static function commentaryExist(int $id)
    {
        $query = DB_Connect::dbConnect()->query("SELECT count(*) as cnt FROM " . self::TABLE . " WHERE id = $id");
        return $query ? $query->fetch()['cnt'] : 0;
    }

    public static function deleteComment (int $id) {
        $query = DB_Connect::dbConnect()->query("
            DELETE FROM ". self::TABLE ." WHERE id = $id
        ");
        if ($query) {
            header("Location: /index.php?c=commentary&a=get-all");
        }
        else {
            header("Location: /index.php?c=home");
        }
    }


}