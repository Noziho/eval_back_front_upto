<?php
if (isset($_SESSION['user'])) {
    header("Location: /index.php?c=home");
}
$messages = [
    "Error: L'identifiant ou le mot de passe est incorrect. ",
];
if (isset($_GET['f'])) {
    $index = (int)$_GET['f'];
    $message = $messages[$index]; ?>
    <div class="error-message <?= strpos($message, "Error: ") === 0 ? 'error' : 'success' ?>"><?= $message ?></div>
    <?php
}

?>
<div class="form-container">
    <form action="/index.php?c=user&a=login" method="post">
        <label for="username_login">Nom d'utilisateur: </label>
        <input type="text" id="username_login" name="username_login">

        <label for="password_login">Mot de passe:  </label>
        <input type="password" id="password_login" name="password_login">

        <input class="form-button" type="submit" name="submit" value="Se connecter">
    </form>
</div>