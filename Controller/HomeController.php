<?php

use App\Controller\AbstractController;
use App\Model\Manager\ArticleManager;

class HomeController extends AbstractController
{
    public function index () {
        $this->render('home/home', [
            'articles' => ArticleManager::getAll()
        ]);
    }

}