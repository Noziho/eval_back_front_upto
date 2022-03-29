<?php

use App\Controller\AbstractController;
use App\Model\Entity\User;


AbstractController::redirectIfNotAllow();


?>

<div class="article-container">
    <h2 class="title-list-article">Lites des utilisateurs : </h2>
    <?php
    if (isset($data)) {
        foreach ($data['users'] as $user) {
            /* @var User $user */ ?>
            <a href="/index.php?c=user&a=show-user&id=<?= $user->getId() ?>">
                <div class="users">
                    <p>Pseudo: <?= " " . $user->getUsername() ?></p>
                    <p>Mail: <?= " " . $user->getMail() ?></p>
                </div>
            </a>

            <?php
        }
    } ?>

</div>