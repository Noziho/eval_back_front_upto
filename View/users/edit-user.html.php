<?php
use App\Controller\AbstractController;
use App\Model\Entity\Role;
use App\Model\Entity\User;

AbstractController::redirectIfNotAllow();
AbstractController::redirectIfRedact();
/* @var User $user */
$user = $data['user'];

?>
<div class="edit-form-container">
    <h1>Modification de l'utilisateur: <?= $user->getUsername() ?> </h1>
    <form action="/index.php?c=user&a=edit-user&id=<?= $user->getId() ?>" method="post">

        <label for="username">Nom d'utilisateur: </label>
        <input type="text" id="username" name="username" minlength="4" maxlength="75" value="<?= $user->getUsername() ?>" required>

        <label for="role">Rôle: </label>
        <select name="role" id="role">

                <?php
                foreach ($user->getRole() as $role) {
                        /* @var Role $role */?>
                    <option value="<?= $role->getId(); ?>"><?= $role->getRoleName(); ?></option><?php
                    }
                ?>

            <option value="1">Admin</option>
            <option value="2">Rédacteur</option>
        </select>

        <input class="form-button" type="submit" name="submit-edit" value="Modifiez">
    </form>
</div>