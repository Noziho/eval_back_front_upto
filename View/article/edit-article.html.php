<?php
use App\Controller\AbstractController;
use App\Model\Entity\Article;

AbstractController::redirectIfNotAllow();
$messages = [
    "Error: Un champ est manquant",
    "Error: Le champ titre doit contenir entre 4 et 100 caractères.",
    "Error: Le champ de résumer doit contenir entre 6 ey 55 caractères",
    "Erroor: Le champ pour le contenu doit contenir au minimum 20 caractères",

];


if (isset($_GET['f'])) {
    $index = (int)$_GET['f'];
    $message = $messages[$index]; ?>
    <div class="error-message <?= strpos($message, "Error: ") === 0 ? 'error' : 'success' ?>"><?= $message ?></div>
    <?php
}

$article = $data['article'];
/* @var Article $article*/
?>
<div class="edit-form-container">
    <h1>Modification de l'article</h1>
    <form action="/index.php?c=article&a=edit-article&id=<?= $article->getId() ?>" method="post">

        <label for="title">Titre: </label>
        <input type="text" id="title" name="title" minlength="4" maxlength="100" value="<?= $article->getTitle() ?>" required>

        <label for="resume">Résumer: </label>
        <input type="text" id="resume" name="resume" minlength="6" maxlength="55" value="<?= $article->getResume()?>" required>

        <label for="content">Contenu: </label>
        <textarea id="content" name="content" minlength="20" required><?= $article->getContent() ?></textarea>

        <input class="form-button" type="submit" name="submit-edit" value="Modifiez">
    </form>
</div>