<?php

use App\Controller\AbstractController;
use App\Model\Entity\Commentary;
use App\Model\Entity\Role;
use App\Model\Entity\User;

AbstractController::redirectIfNotAllow();
?>


<div class="commentary-container"><?php
    if (isset($data['comments'])) {
        $comments = $data['comments'];
        foreach ($comments as $comment) {
            /* @var Commentary $comment */ ?>
            <div class="commentary">
            <div>
                <p>Auteur: <?= $comment->getAuthor()->getUsername() ?></p>
            </div>
            <div>
                <p>Contenu du commentaire: <?= $comment->getContent() ?></p>

            </div>
            <div>
                <p>Titre de l'article: <?= $comment->getArticle()->getTitle() ?></p>
            </div>
            </div><?php
            if (isset($_SESSION['user'])) {

                $user = $_SESSION['user'];
                /* @var User $user */

                foreach ($user->getRole() as $role) {
                    /* @var Role $role */
                    $currentRole = $role->getRoleName();
                    if ($currentRole === 'admin') { ?>
                        <div>
                            <a class="delete" href="/index.php?c=commentary&a=delete-comment&id=<?= $comment->getId() ?>">Supprimez</a>
                        </div>
                        <?php

                    }
                }
            }
        }
    }
    ?>
</div>
