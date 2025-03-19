<?php
/********* Member Card *********/

// Variable HereDoc communes
$privatePage = true; //quel type de page doit être généré
$avatar = $user->getAvatar();
$pseudo = $user->getPseudo();
$seniority = UserManager::calculationSeniority($user->getRegisterDate());
$nbBooks = count($books) > 1 ? count($books) . ' Livres' : count($books) . 'Livre';

// Variable Heredoc conditionné en fonction de la visibilité du profil (Public/privée)
if ($privatePage){
    $titleH1 = <<<HTML
        <h1>Mon Compte</h1>
    HTML;
    $modifyLink = <<<HTML
        <a href="#">modifier</a>
    HTML;
    $buttonWriteMessage =null;
    $classTopContainer = 'privatePageTopContainer';
}else{
    $titleH1 = null;
    $modifyLink = null;
    $buttonWriteMessage =<<<HTML
        <button type="submit">Envoyer un message</button>
    HTML;
    $classTopContainer = 'publicPageTopContainer';
}

$personalContent = <<<HTML
    <section class="memberPageSection">
        $titleH1
        <div class="memberPageTopContainer">
            <div class="memberPageInformationMember $classTopContainer">
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
                        <img src="ressources\Vector.png" alt="icone livres">
                        <p>$nbBooks</p>
                    </div>
                </div>
                $buttonWriteMessage
            </div>
HTML;

/********* Book Table *********/
// Variables HereDoc communes
$booksTable = null;
$bookTableClose = <<<HTML
            </tbody>
        </table>
    </section>
    HTML;
// Variable Heredoc conditionné en fonction de la visibilité du profil (Public/privée)
if ($privatePage){
    $headerTablePrivate = <<<HTML
        <th class="bookTableHead" scope="col">
            <p class="partTitle">DISPONIBILITE</p>
        </th>
        <th class="bookTableHead" scope="col">
            <p class="partTitle">ACTION</p>
        </th>
    HTML;
    $tableWidth = '';
}else{
    $headerTablePrivate = null;
    $contentTablePrivate = null;
    $tableWidth = 'publicTableWidth';
}

$headerTable = <<<HTML
    <table class="bookTable $tableWidth">
        <thead>
            <tr>
                <th class="bookTableHead" scope="col">
                    <p class="partTitle">PHOTO</p>
                </th>
                <th class="bookTableHead" scope="col">
                    <p class="partTitle">TITRE</p>
                </th>
                <th class="bookTableHead" scope="col">
                    <p class="partTitle">AUTEUR</p>
                </th>
                <th class="bookTableHead thDesc" scope="col">
                    <p class="partTitle">DESCRIPTION</p>
                </th>
                $headerTablePrivate
            </tr>
        </thead>
        <tbody>
    HTML;

    $i=1;
    foreach ($books as $book) {
        $i++;
        // Variable Heredoc pour l'affichage de la page
        $title = $book->getTitle();
        $author = $book->getAuthor();
        $description = $book->getComment(100);
        $picture = $book->getPicture();
        $available = $book->getAvailable() ? 'disponible' : 'non dispo.';
        $availableClass = $book->getAvailable() ? 'available' : 'unavailable';
        $idClass = $i % 2 == 0 ? 'pair' : 'odd';
        if ($privatePage){
            $contentTablePrivate = <<<HTML
                <td><div class ="bookStatus $availableClass">$available</div></td>
                <td>
                    <div class="actionTable">
                        <a class="actionLink actionEdit" href="#">Editer</a>
                        <a class="actionLink actionDelete" href="#">Supprimer</a>
                    </div>
                </td>
            HTML;
        }

        $booksTable .= <<<HTML
            <tr class="$idClass">
                <th scope="row"><img src="$picture" alt="Photo du livre : $title"></th>
                <td>$title</td>
                <td>$author</td>
                <td><div class="italic">$description</div></td>
                $contentTablePrivate
            </tr>
        HTML;
    }
    $booksTable .= $bookTableClose;