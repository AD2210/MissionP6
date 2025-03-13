<?php
// Variable Heredoc pour la page
//@todo peut-être refacto le formulaire à part car utiliser 3 fois
// @todo idem pour carte présentation personnel

$avatar = $user->getAvatar();
$pseudo = $user->getPseudo();
$seniority = UserManager::calculSeniority($user->getRegisterDate());
$nbBooks = count($books) > 1 ? count($books) . ' Livres' : count($books) . 'Livre';
$email = $user->getEmail();
$password = $user->getPassword(); //@todo prévoir le hash si besoin

$personalContent = <<<HTML
    <section class="privatePageSection">
        <h1>Mon Compte</h1>
        <div class="privatePageTopContainer">
            <div class="privatePageContainer">
                <div class="avatarContainer"> 
                    <img class ="bigAvatar" src="$avatar" alt="photo du membre : $pseudo">
                    <a href="#">modifier</a>
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
            </div>

            <div class="privatePageContainer loginForm">
                <form action="#">
                    <p>Vos informations personnelles</p>
                    <div class="formField">
                        <label for="email">Adresse email</label>
                        <input type="email" name="email" id="email" value="$email">
                    </div>
                    <div class="formField">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" value="$password">
                    </div>
                    <div class="formField">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" name="pseudo" id="pseudo" value="$pseudo">
                    </div>
                    <div class="formField">
                        <button type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
HTML;

echo $personalContent;
?>
<table class="bookTable">
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
            <th class="bookTableHead" scope="col">
                <p class="partTitle">DISPONIBILITE</p>
            </th>
            <th class="bookTableHead" scope="col">
                <p class="partTitle">ACTION</p>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i=1;
        // On affiche ici la liste des livres possédés par le membre
        foreach ($books as $book) {
            // Variable Heredoc pour l'affichage de la page
            $i++;
            $title = $book->getTitle();
            $author = $book->getAuthor();
            $description = $book->getComment(100);
            $available = $book->getAvailable() ? 'disponible' : 'non dispo.';
            $availableClass = $book->getAvailable() ? 'available' : 'unavailable';
            $picture = $book->getPicture();
            $idClass = $i % 2 == 0 ? 'pair' : 'odd';

            $booksTable = <<<HTML
                    <tr class="$idClass">
                        <th scope="row"><img src="$picture" alt="Photo du livre : $title"></th>
                        <td>$title</td>
                        <td>$author</td>
                        <td><div class="italic">$description</div></td>
                        <td><div class ="bookStatus $availableClass">$available</div></td>
                        <td>
                            <div class="actionTable">
                                <a class="actionLink actionEdit" href="#">Editer</a>
                                <a class="actionLink actionDelete" href="#">Supprimer</a>
                            </div>
                        </td>
                    </tr>
                HTML;
            echo $booksTable;
        }
        ?>
    </tbody>
</table>
</section>