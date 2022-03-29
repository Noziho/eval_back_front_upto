<?php

use App\Controller\AbstractController;
use App\Model\Entity\Article;
use App\Model\Entity\Commentary;

/* @var Article $article */
$article = $data['article'];


if (isset($data['article'])) { ?>
    <div class="article-container">
        <h1 class="article-title"><?= $article->getTitle() ?></h1>
        <?= $article->getContent() ?>
        <p>Auteur: <?= $article->getAuthor()->getUsername() ?></p>
    </div>
    <?php
    if (isset($_SESSION['user'])) { ?>
        <div class="commentary-container">
        <h1>Ajoutez un commentaire: </h1>
        <form action="/index.php?c=commentary&a=add-comment&id=<?= $article->getId() ?>" method="post">
            <label for="content">Votre commentaire: </label>
            <textarea name="content" id="content" cols="30" rows="10" placeholder="Votre commentaire" minlength="10"
                      maxlength="255"></textarea>

            <input type="submit" name="submit" id="submit">
        </form>

        </div><?php
    }
}
?>


<div class="commentary-container">
    <h1 class="title-list-commentary">Commentaires: </h1>
    <?php
    if (isset($data['comments'])) {
        /* @var Commentary $comments */
        $comments = $data['comments'];


        foreach ($comments as $comment) {
            if (isset($comment)) {
                /* @var Commentary $comment */ ?>
                <div class="commentary">
                <div>
                    <p><?= $comment->getAuthor()->getUsername() ?>: <?= $comment->getContent() ?></p>
                </div>
                </div><?php

            }
        }
    }
    ?>
</div>

