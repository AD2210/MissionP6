<?php
/** 
 * Template principale qui va inclure les vues générées
 * Doit recevoir en variable : 
 * string $title : Titre de la page
 *  string $content : Contenu du main
 * */

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Tom Troc</title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='css' media='screen' href='style.css'>
        <script src="https://kit.fontawesome.com/988c8cacf7.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <header>
            <nav>
                <img src="\ressources\logo.png" alt="Logo Tom Troc">
                <a href="#">Accueil</a>
                <a href="#">Nos livres à l'échange</a>
                <div>
                    <a href="#">Messagerie</a>
                    <a href="#">Mon compte</a>
                    <?php
                // Si on est connecté, on affiche le bouton de déconnexion, sinon, on affiche le bouton de connexion : 
                if (isset($_SESSION['user'])) {
                    echo '<a href="#">Déconnexion</a>';
                }else{
                    echo '<a href="#">Connexion</a>';
                }
                ?>
                </div>
            </nav>
        </header>

        <main>
            Hello
            <?= $content; /* Affichage du contenu de la page. */?>
        </main>
        
        <footer>
            <a href="#">politique de confidentialité</a>
            <a href="#">mentions légales</a>
            <a href="#">Tom Troc <i class="fa-regular fa-copyright"></i></a>
            <img src="\ressources\Logo_footer.png" alt="Logo double T Tom Troc">
        </footer>
    </body>
</html>