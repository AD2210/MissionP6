<?php
/**
 * Template permettant de généré les vues communes à page privé et page public
 */

/********* Member Card *********/

// Variable HereDoc communes
$idUser = $user->getId();
$avatar = $user->getAvatar();
$pseudo = $user->getPseudo();
$seniority = UserManager::calculationSeniority($user->getRegisterDate());
$nbBooks = count($books) > 1 ? count($books) . ' Livres' : count($books) . 'Livre';

// Variable Heredoc conditionné en fonction de la visibilité du profil (Public/privée)
if ($privatePage) {
    $titleH1 = <<<HTML
        <h1>Mon Compte</h1>
    HTML;
    $modifyLink = <<<HTML
        <a href="#">modifier</a>
    HTML;
    $bottomButton = <<<HTML
        <a href="index.php?action=editBook&id=-1" class="button notImplemented">Ajouter un livre</a>
    HTML;;
    $topContainerClass = 'privatePageTopContainer';
} else {
    $titleH1 = null;
    $modifyLink = null;
    $bottomButton = <<<HTML
        <a href="index.php?action=messaging&corresponding=$idUser" class="button">Envoyer un message</a>
    HTML;
    $topContainerClass = 'publicPageTopContainer';
}

$personalContent = <<<HTML
    <section class="memberPageSection">
        <div class="memberPageMainContainer">
            $titleH1
            <div class="memberPageTopContainer">
                <div class="memberPageInformationMember $topContainerClass">
                    <div class="avatarContainer"> 
                        <img class ="bigAvatar" src="$avatar" alt="photo du membre : $pseudo">
                        $modifyLink
                    </div>
                    <span>———————————————</span>
                    <div class="infoMember">
                        <h2>$pseudo</h2>
                        <span>$seniority</span>
                        <p class="partTitle">BIBLIOTHEQUE</p>
                        <div class="nbBooks">
                            <img src="ressources/Vector.png" alt="icone livres">
                            <p>$nbBooks</p>
                        </div>
                    </div>
                    $bottomButton
                </div>       
HTML;

/********* Book Table *********/
// Variables HereDoc communes
$booksTable = null;

// Variable Heredoc conditionné en fonction de la visibilité du profil (Public/privée)
if ($privatePage) {
    $headerTablePrivate = <<<HTML
        <th class="bookTableHead tAvailable" scope="col" id="head-E">
            <p class="partTitle">DISPONIBILITE</p>
        </th>
        <th class="bookTableHead tAction" scope="col" id="head-F">
            <p class="partTitle">ACTION</p>
        </th>
    HTML;
    $tableWidthClass = '';

    $bookTableClose = <<<HTML
                </tbody>
            </table>
        </div>
    </section>
    HTML;
} else {
    $headerTablePrivate = null;
    $contentTablePrivate = null;
    $tableWidthClass = 'publicTableWidth';
    $bookTableClose = <<<HTML
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    HTML;
}

$headerTable = <<<HTML
    <table class="bookTable $tableWidthClass">
        <thead>
            <tr>
                <th class="bookTableHead tPicture" scope="col" id="head-A">
                    <p class="partTitle">PHOTO</p>
                </th>
                <th class="bookTableHead tTitle" scope="col" id="head-B">
                    <p class="partTitle">TITRE</p>
                </th>
                <th class="bookTableHead tAuthor" scope="col" id="head-C">
                    <p class="partTitle">AUTEUR</p>
                </th>
                <th class="bookTableHead tDescription" scope="col" id="head-D">
                    <p class="partTitle">DESCRIPTION</p>
                </th>
                $headerTablePrivate
            </tr>
        </thead>
        <tbody>
    HTML;

$i = 1;
foreach ($books as $book) {
    $i++; //Variable permettant un affichage différencier des ligne paires et impares
    // Variable Heredoc pour l'affichage de la page
    $id = $book->getId();
    $title = $book->getTitle();
    $author = $book->getAuthor();
    $description = $book->getComment(100);
    $picture = $book->getPicture();
    $available = $book->getAvailable() ? 'disponible' : 'non dispo.';
    $availableClass = $book->getAvailable() ? 'available' : 'unavailable';
    $lineClass = $i % 2 == 0 ? 'pair' : 'odd';

    //Affichage des lignes pour la partie Privée
    if ($privatePage) {
        $contentTablePrivate = <<<HTML
                <td class="tAvailable" headers="head-$i head-E"><div class ="bookStatus $availableClass">$available</div></td>
                <td class="tAction" headers="head-$i head-F">
                    <div class="actionTable">
                        <a class="actionLink actionEdit" href="index.php?action=editBook&id=$id">Editer</a>
                        <a class="actionLink actionDelete" href="index.php?action=deleteBook&id=$id">Supprimer</a>
                    </div>
                </td>
            HTML;
    }

    //Affichage des lignes pour la partie public
    $booksTable .= <<<HTML
            <tr class="$lineClass">
                <th class="tPicture" scope="row" id="head-$i"><img src="$picture" alt="Photo du livre : $title"></th>
                <td class="tTitle" headers="head-$i head-B">$title</td>
                <td class="tAuthor" headers="head-$i head-C">$author</td>
                <td class="tDescription" headers="head-$i head-D"><div class="italic">$description</div></td>
                $contentTablePrivate
            </tr>
        HTML;
}
$booksTable .= $bookTableClose;