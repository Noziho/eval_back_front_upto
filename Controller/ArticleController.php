<?php

use App\Controller\AbstractController;
use App\Model\Manager\ArticleManager;
use App\Model\Manager\CommentaryManager;
use App\Model\Manager\UserManager;

class ArticleController extends AbstractController
{

    public function index()
    {
        $this->render('home/home');
    }

    /**
     * show more details for each article
     * @param int|null $id
     */
    public function showArticle(int $id = null)
    {
        if (null === $id) {
            header("Location: /index.php?c=home");
        }
        if (ArticleManager::articleExist($id)) {
            $this->render('article/article', [
                "article" => ArticleManager::getArticleById($id),
                'comments' => CommentaryManager::getCommentsByArticle(ArticleManager::getArticleById($id)),
            ]);
        } else {
            $this->index();
        }

    }

    /**
     * a function for create an article
     * @param $id
     */
    public function createArticle($id)
    {
        $this->render("article/createArticle", [
            'users' => UserManager::getUserById($id)
        ]);

        if (isset($_POST['submit'])) {
            if (!$this->formIsset('title', 'resume', 'content')) {
                header("Location: /index.php?c=article&a=create-article&f=2");
            }

            ArticleManager::createArticle($id);

        }
    }


    /**
     * a function for delete an article
     * @param int $id
     */
    public function deleteArticle(int $id)
    {
        if (ArticleManager::articleExist($id)) {
            ArticleManager::deleteArticle($id);
            $this->render('home/home');
        } else {
            $this->index();
        }
    }

    /**
     * a function for edit an article
     * @param int $id
     */
    public function editArticle(int $id)
    {
        $this->render('article/edit-article', [
            'article' => ArticleManager::getArticleById($id)
        ]);
        if (isset($_POST['submit-edit'])) {
            if (!$this->formIsset('title', 'content', 'resume')) {
                header("Location: /index.php?c=article&a=edit-article&id={$id}&f=0");
                exit();
            }
            if (ArticleManager::articleExist($id)) {
                $title = filter_var($_POST['title'], FILTER_SANITIZE_STRING);
                $resume = filter_var($_POST['resume'], FILTER_SANITIZE_STRING);
                $content = filter_var($_POST['content'], FILTER_SANITIZE_STRING);

                $this->checkRange($title, 4, 100, "/index.php?c=article&a=edit-article&id=$id&f=1");
                $this->checkRange($resume, 6, 55, "/index.php?c=article&a=edit-article&id=$id&f=2");
                $this->checkRange($content, 20, 55000, "/index.php?c=article&a=edit-article&id=$id&f=3");

                ArticleManager::editArticle($id, $title, $resume, $content);
                header("Location: /index.php?c=home&f=6");
            }
            else {
                $this->index();
            }
        }

    }

}