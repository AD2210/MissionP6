<?php
    // page par défaut : inscription
    $title = 'Connexion';
    $ConnexionForm = <<<HTML
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

    $inscriptionForm = <<<HTML
        HTML;

    if ($connexion == "false"){
        $connexionMessage = <<<HTML
                <div class="formField">
                    <button class="button" type="submit">S’inscrire</button>
                </div>
                <p>Déjà inscrit ? <a href="index.php?action=loginPage&connexion=true">Connectez-vous</a></p> 
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

    $loginPage = <<<HTML
        <div class="loginForm">
            <h1>$title</h1>
            <form action="index.php?action=connectUser" method="post">
                $inscriptionForm
                $ConnexionForm
            $connexionMessage
        </div>
        HTML;
?> 
<section class="loginPageSection">
    <?= $loginPage; ?>
    <img src="\ressources\dd6bbafe9a461f128299f90d445728dd.jpeg" alt="photo d'une bibliothèque">
</section>