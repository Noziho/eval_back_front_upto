<?php

use App\Controller\AbstractController;
use App\Model\Manager\CommentaryManager;

class CommentaryController extends AbstractController
{

    public function index()
    {
        $this->render('article/article');
    }

    public function addComment (int $id)
    {
        if (isset($_POST['submit'])) {
            if (!$this->formIsset('content')) {
                header("Location: /index.php?c=home&f=7");
                exit();
            }
            $this->checkRange(filter_var($_POST['content'], FILTER_SANITIZE_STRING), '10', '255', '/index.php?c=home&f=8');

            CommentaryManager::addComment($id);


        }
    }

    public function deleteComment (int $id)
    {
        if (CommentaryManager::commentaryExist($id)) {
            CommentaryManager::deleteComment($id);
            $this->render('users/commentary');
        }
        else {
            $this->index();
        }
    }

    public function getAll ()
    {
        $this->render('users/commentary', [
            'comments' => CommentaryManager::getAll(),
        ]);
    }
}