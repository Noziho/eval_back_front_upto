<?php

use App\Controller\AbstractController;

AbstractController::redirectIfNotAllow();
?>

<div class="creation-article-container">
    <form action="/index.php?c=article&a=create-article&id=<?= $_SESSION['id'] ?>" method="post">

        <h1>Création d'un article: </h1>
        <label for="title">Titre: </label>
        <input type="text" id="title" name="title" required>

        <label for="resume">Résumer</label>
        <input type="text" id="resume" name="resume" required>

        <label for="content">Contenu: </label>
        <textarea name="content" id="content" cols="60" rows="10"></textarea>

        <input type="submit" name="submit" class="form-button" value="Crée mon article">

    </form>
</div>