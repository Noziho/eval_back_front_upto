<?php

use App\Model\Entity\Article;
use App\Model\Entity\Role;
use App\Model\Entity\User;

$messages = [
    "Success: Connexion réussi.",
    "Sucess: Déconnexion réussi.",
    "Error: Vous devez être connecter pour pouvoir vous déconnecter",
    "Sucess: Votre article à bien été créer",
    "Error: Erreur lors de la création de l'article",
    "Sucess: L'article à été supprimer avec succès",
    "Sucess: L'article à été modifiez avec succès",
    "Error: Un champ pour le commentaire est manquant",
    "Error: La longueur du champ commentaire doit-être comprise entre 20 et 255",
    "Error: Le champ password est manquant",
];


if (isset($_GET['f'])) {
    $index = (int)$_GET['f'];
    $message = $messages[$index]; ?>
    <div class="error-message <?= strpos($message, "Error: ") === 0 ? 'error' : 'success' ?>"><?= $message ?></div>
    <?php
}

?>


<div class="article-container">
    <h2 class="title-list-article">Article récent: </h2>
    <?php
    if (isset($data['articles'])) {
        foreach ($data['articles'] as $article) {
            /* @var Article $article */ ?>
            <div class="articles">
            <a href="/index.php?c=article&a=show-article&id=<?= $article->getId() ?>">

                <p>Titre: <?= $article->getTitle() ?></p>
                <p>Résumé: <?= $article->getResume() ?></p>
                <p>Auteur: <?= $article->getAuthor()->getUsername() ?></p>
            </a>
            </div><?php
            if (isset($_SESSION['user'])) {

                $user = $_SESSION['user'];

                /* @var User $user */
                foreach ($user->getRole() as $role) {
                    /* @var Role $role */
                    $currentRole = $role->getRoleName();
                    if ($currentRole === 'admin') { ?>
                        <div>
                            <a class="edit" href="/index.php?c=article&a=edit-article&id=<?= $article->getId() ?>">Modifiez</a>
                            <a class="delete" href="/index.php?c=article&a=delete-article&id=<?= $article->getId() ?>">Supprimez</a>
                        </div>
                        <?php

                    }
                }
            }
        }

    } ?>

</div>

<iframe class="discord-iframe" src="https://discord.com/widget?id=744671444817936425&theme=light"
        height="500" allowtransparency="true" frameborder="0"
        sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts"></iframe>


