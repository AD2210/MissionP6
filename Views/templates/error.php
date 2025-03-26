<?php
/**
 * Template pour afficher une page d'erreur.
 */

$errorContent = <<<HTML
    <div class="error">
        <h2>Erreur</h2>
        <p>$errorMessage</p>
        <a href="index.php">Retour à la page d'accueil</a>
    </div>
 HTML;

 echo $errorContent;


