<?php
/** 
 * Template principale qui va inclure les vues générées
 * Doit recevoir en variable : 
 * string $title : Titre de la page
 * string $content : Contenu du main
 * @todo mettre un hereDoc ici pour plus de lisibilité
 * */
require_once 'src/models/MessageManager.php';

/**
 * Variable d'affichage conditionné
 */

 //On récupère le nombe de message non lu si l'utilisateur est loggé
 $nbMessagesUnreadClass = '';
if(isset($_SESSION['user'])){
    $messageManager = new MessageManager;
    $nbMessagesUnread = $messageManager->getNumberOfMessagesByIdReceiver($_SESSION['idUser']);
}else{
    $nbMessagesUnreadClass = 'noMessageUnread';
    $nbMessagesUnread = 0;
}

// On applique une class css dans la navbar pour mettre en gras la page active
$activePage = Service::request('action', 'home');

//initialisation des variables
$homePageClass = '';
$allBooksClass = '';
$messagingClass = '';
$memberPageClass = '';
$loginPageClass ='';

//On applique la class en fonction de la page active
switch ($activePage) {
    case 'home' :
        $homePageClass = 'activePage';
        break;
    case 'allBooks' :
        $allBooksClass = 'activePage';
        break;
    case 'oneBook' :
        $allBooksClass = 'activePage';
        break;
    case 'messaging' :
        $messagingClass = 'activePage';
        break;
    case 'editBook' :
        $memberPageClass = 'activePage';
        break;
    case 'privatePage' :
        $memberPageClass = 'activePage';
        break;
    case 'publicPage' :
        $memberPageClass = 'activePage';
        break;
    case 'loginPage' :
        $loginPageClass = 'activePage';
        break;
    default :
    $homePageClass = 'activePage';
}


/**
 * Template header/footer du site auquel on ajoute le contenu de la page demandé
 */
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
                <img src="/ressources/logo.png" alt="Logo Tom Troc">
                <div class="navbarNav">
                    <a class ="<?= $homePageClass; ?>" href="index.php?action=home">Accueil</a>
                    <a class ="<?= $allBooksClass; ?>" href="index.php?action=allBooks">Nos livres à l'échange</a>
                </div>    
                <div class="navbarNav navAdmin">
                        <a class ="iconLink <?= $messagingClass; ?>" href="index.php?action=messaging">
                                <img src="/ressources/IconMessagerie.png" alt="icone messagerie">
                                Messagerie
                                <span class="<?= $nbMessagesUnreadClass; ?>"><?= $nbMessagesUnread; ?></span>
                        </a>
                    <a class ="iconLink <?= $memberPageClass; ?>" href="index.php?action=privatePage">
                        <img src="/ressources/IconMonCompte.png" alt="icone mon compte">
                        Mon compte
                    </a>
                    <?php
                // Si on est connecté, on affiche le bouton de déconnexion, sinon, on affiche le bouton de connexion : 
                if (isset($_SESSION['user'])) {
                    echo '<a href="index.php?action=disconnectUser">Déconnexion</a>';
                }else{
                    echo '<a class="'.$loginPageClass. '" href="index.php?action=loginPage&connexion=true">Connexion</a>';
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
            <a href="VosMentionsLégales.pdf" target="_blank">Mentions légales</a>
            <a href="PHP+Sf+P6+-+Specifications+fonctionnelles.pdf" target="_blank">Tom Troc ©</a>
            <img src="/ressources/Logo_footer.png" alt="Logo double T Tom Troc">
        </footer>
    </body>
</html>