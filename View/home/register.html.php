<?php
if (isset($_SESSION['user'])) {
    header("Location: /index.php?c=home");
}
$messages = [
    'Error: Global error !',
    'Error: L\'adresse mail doit être au format mail@exemple.com',
    'Error: La longeur du pseudo doit-être comprise entre 5 et 25 caractères.',
    "Error: La longueur de l'adresse mail doit-être comprise entre 7 et 120 caractères.",
    "Error: La longueur du password doit-être comprise entre 8 et 50 caractères.",
    "Error: Les mots de passes ne correspondent pas.",
    "Success: Inscription réussi vous pouvez désormais vous connecter.",
    "Error: L'adresse mail est déjà utiliser.",
    "Error: Le nom d'utilisateur est déjà utiliser",
];
if (isset($_GET['f'])) {
    $index = (int)$_GET['f'];
    $message = $messages[$index]; ?>
    <div class="error-message <?= strpos($message, "Error: ") === 0 ? 'error' : 'success' ?>"><?= $message ?></div>
    <?php
}

?>
<div class="form-container">
    <form action="/index.php?c=user&a=register" method="post">
        <label for="username">Nom d'utilisateur: </label>
        <input type="text" id="username" name="username" minlength="4" maxlength="75" required>

        <label for="mail">Adresse mail: </label>
        <input type="email" id="mail" name="mail" minlength="8" maxlength="150" required>

        <label for="password">Mot de passe: </label>
        <input type="password" id="password" name="password" minlength="8" maxlength="50" required>

        <label for="password_repeat">Répétez le mot de passe: </label>
        <input type="password" id="password_repeat" name="password_repeat" minlength="8" maxlength="50" required>

        <input class="form-button" type="submit" name="submit" value="S'inscrire">
    </form>
</div>