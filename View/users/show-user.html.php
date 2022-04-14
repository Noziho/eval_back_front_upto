<?php

use App\Controller\AbstractController;
use App\Model\Entity\Role;
use App\Model\Entity\User;

AbstractController::redirectIfNotAllow();
AbstractController::redirectIfRedact();
/* @var User $user */
$user = $data['user'];


if (isset($data['user'])) {?>

<div class="article-container">
    <p>Pseudo: <?=" ". $user->getUsername() ?></p>
    <p>Mail:<?=" ". $user->getMail() ?></p>
    <?php
        foreach ($user->getRole() as $role) {
            /* @var Role $role */?>
            <p>Rôle: <?= " " . $role->getRoleName() ?></p><?php
        }
    ?>
    <a href="/index.php?c=user&a=edit-user&id=<?= $user->getId() ?>"><button type="submit">Modifiez l'utilisateur</button></a>
    <a href="/index.php?c=user&a=delete-user&id=<?= $user->getId() ?>"><button type="submit">Supprimez l'utilisateur</button></a>

</div><?php
}
else {
    header("Location: /index.php?c=home");
}