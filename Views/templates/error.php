<?php
/**
 * Template pour afficher une page d'erreur.
 */

//Variable HereDoc

$previousUrl = Service::getPreviousUrl();

$errorContent = <<<HTML
    <div class="error">
        <h2>Erreur</h2>
        <p>$errorMessage</p>
        <a href="$previousUrl">Retour à la page précédente</a>
    </div>
 HTML;

 echo $errorContent;


