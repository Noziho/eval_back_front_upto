<?php

use App\Controller\AbstractController;

class ErrorController extends AbstractController
{
    public function index()
    {
        // TODO: Implement index() method.
    }

    public function error404 ($askPage) {
        $this->render('error/404');
    }

}