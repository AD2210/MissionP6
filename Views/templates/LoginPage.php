<?php
/**
 * Template d'affichage de la page Login
 */

//On initialise la variable de l'action du formulaire pour le cas Connection
$actionForm = 'index.php?action=connectUser';

$title = 'Connexion';
$ConnexionForm = <<<HTML
            <input type="hidden" name="redirectUrl" value=$redirectUrl>
            <div class="formField">
                <label for="email">Adresse email</label>
                <input type="email" name="email" id="email">
            </div>
            <div class="formField">
                <label for="password">Mot de passe</label>
                <input type="password" name="password" id="password">
            </div>
    HTML;

$connexionMessage = <<<HTML
        <div class="formField">
                <button class="button" type="submit">Se connecter</button>
            </div>
            <p>Pas de compte ? <a href="index.php?action=loginPage&connexion=false">Inscrivez-vous</a></p> 
        </form> 
    HTML;

$inscriptionForm = null;

//On test si l'utilisateur demande à s'inscrire et on régénère le formulaire correspondant
if ($connexion == "false") {
    $actionForm = 'index.php?action=createUser';
    $connexionMessage = <<<HTML
                <div class="formField">
                    <button class="button" type="submit">S’inscrire</button>
                </div>
                <p class="connexionMessage">Déjà inscrit ? <a href="index.php?action=loginPage&connexion=true">Connectez-vous</a></p> 
            </form>     
            HTML;

    $title = 'Inscription';
    $inscriptionForm = <<<HTML
                <div class="formField">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" name="pseudo" id="pseudo">
                </div>
            HTML;
}


//On génénère la vue finale avec les vues partielles paramétrés plus haut et on l'affiche
$loginPage = <<<HTML
    <section class="loginPageSection">
        <div class="loginContainer">
            <div class="loginForm">
                <h1>$title</h1>
                <form action="$actionForm" method="POST">
                    $inscriptionForm
                    $ConnexionForm
                    $connexionMessage
            </div>
            <img src="ressources/dd6bbafe9a461f128299f90d445728dd.jpeg" alt="photo d'une bibliothèque">
        </div>
    </section>
    HTML;

echo $loginPage;
?>