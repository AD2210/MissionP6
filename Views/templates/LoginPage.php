<?php

$title = 'Inscription';
// page par défaut : Inscription
$loginPage = <<<HTML
    $title
    <form action="#">
        <label for="pseudo">Pseudo</label>
        <input type="text" name="pseudo" id="pseudo">
        <label for="email">Adresse email</label>
        <input type="email" name="email" id="email">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="S’inscrire">
    </form>
    <p>Déjà inscrit ? <a href="#">Connectez-vous</a></p>
    HTML;
    
//@todo mettre la condition avec le _get récuperé en URL
if ('connexion'){
    $title = 'Connexion';
    $loginPage = <<<HTML
    $title
    <form action="#">
        <label for="email">Adresse email</label>
        <input type="email" name="email" id="email">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Se connecter">
    </form>
    <p>Pas de compte ? <a href="#">Inscrivez-vous</a></p>
    HTML;
}
?>

<section class="loginPageSection">
    <?= $loginPage; ?>
    <img src="\ressources\dd6bbafe9a461f128299f90d445728dd.jpeg" alt="photo d'une bibliothèque">
</section>

