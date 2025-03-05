<?php
// Variable Heredoc pour la page
//@todo peut-être refacto le formulaire à part car utiliser 3 fois
// @todo idem pour carte présentation personnel

$avatar = $user->getAvatar();
$pseudo = $user->getPseudo();
$seniority = $user->getDateCreation(); //@todo faire le calcul ici via methode static dans user manager avec unité
$nbBooks = $book->getNbBooksByIdMember(); //@todo créer la méthode static dans book manager avec unité (livre ou livres)

$personalContent = <<<HTML
    <div class="privatePresentation">
        <div> 
            <img src="$avatar" alt="photo du membre : $pseudo">
        </div>
        <div>
            <h2>$pseudo</h2>
            <p>Membre depuis $seniority</p>
            <p>BIBLIOTHEQUE</p>
            <div>
                <img src="" alt="">
                <p>$nbBooks</p>
            </div>
        </div>   
    </div>
HTML;

echo $personalContent;
?>

<table>
    <thead>
        <tr>
            <th scope="col">PHOTO</th>
            <th scope="col">TITRE</th>
            <th scope="col">AUTEUR</th>
            <th scope="col">DESCRIPTION</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // On affiche ici la liste des livres possédés par le membre
        foreach ($books as $book){
            // Variable Heredoc pour l'affichage de la page
            $title = $book->getTitle();
            $author = $book->getAuthor();
            $description = $book->getComment();
            $available = $book->getAvailable() ? 'disponible' : 'non dispo.';
            $availableClass = $book->getAvailable() ? 'available' : 'unavailable';
            $picture = $book->getPicture();

            $booksTable = <<<HTML
                <tr>
                    <th scope="row"><img src="$picture" alt="Photo du livre : $title"></th>
                    <td>$title</td>
                    <td>$author</td>
                    <td>$decription</td>
                </tr>
            HTML;
            echo $booksTable;
        }
        ?>
    </tbody>
</table>
