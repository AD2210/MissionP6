<?php
/** 
 * Template principale qui va inclure les vues générées
 * Doit recevoir en variable : 
 * string $title : Titre de la page
 * string $content : Contenu du main
 * */

require_once 'src\models\MessageManager.php';
// Variable d'affichage conditionné
if(isset($_SESSION['user'])){
    $messageManager = new MessageManager;
    $nbMessagesUnread = $messageManager->getNumberOfMessagesByIdReceiver($_SESSION['idUser']);
}else{
    $nbMessagesUnreadClass = 'noMessageUnread';
}
$activePage = Service::request('action', 'home');
var_dump($activePage);
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Tom Troc - <?= $title ?></title>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' href='./css/style.css'>
    </head>

    <body>
        <header>
            <nav class="navbar">
                <img src="\ressources\logo.png" alt="Logo Tom Troc">
                <div class="navbarNav">
                    <a href="index.php?action=home">Accueil</a>
                    <a href="index.php?action=allBooks">Nos livres à l'échange</a>
                </div>    
                <div class="navbarNav navAdmin">
                        <a class ="iconLink" href="index.php?action=messaging">
                                <img src="ressources\Icon messagerie.png" alt="icone messagerie">
                                Messagerie
                                <span class="<?= $nbMessagesUnreadClass ?>"><?= $nbMessagesUnread ?></span>
                        </a>
                    <a class ="iconLink" href="index.php?action=privatePage">
                        <img src="ressources\Icon mon compte.png" alt="icone mon compte">
                        Mon compte
                    </a>
                    <?php
                // Si on est connecté, on affiche le bouton de déconnexion, sinon, on affiche le bouton de connexion : 
                if (isset($_SESSION['user'])) {
                    echo '<a href="index.php?action=disconnectUser">Déconnexion</a>';
                }else{
                    echo '<a href="index.php?action=loginPage&connexion=true">Connexion</a>';
                }
                ?>
                </div>
            </nav>
        </header>

        <main>
            <?= $content; /* Affichage du contenu de la page. */?>
        </main>
        
        <footer>
            <a href="Politique-de-confidentialite-rgpd.pdf" target="_blank">Politique de confidentialité</a>
            <a href="Vos mentions légales.pdf" target="_blank">Mentions légales</a>
            <a href="PHP+Sf+P6+-+Specifications+fonctionnelles.pdf" target="_blank">Tom Troc <i class="fa-regular fa-copyright"></i></a>
            <img src="\ressources\Logo_footer.png" alt="Logo double T Tom Troc">
        </footer>
    </body>
</html>