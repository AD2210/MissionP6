<?php
// Variable Heredoc pour la page
//@todo peut-être refacto le formulaire à part car utiliser 3 fois
// @todo idem pour carte présentation personnel

$avatar = $user->getAvatar();
$pseudo = $user->getPseudo();
$seniority = UserManager::calculSeniority($user->getRegisterDate());
$nbBooks = count($books) > 1 ? count($books) .' Livres' : count($books) . 'Livre';
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

            <div class="privatePageContainer">
                <p>Vos informations personnelles</p>
                <form action="#">
                <label for="pseudo">Pseudo</label>
                    <input type="text" name="pseudo" id="pseudo">
                    <label for="email">Adresse email</label>
                    <input type="email" name="email" id="email">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password">
                    <input type="submit" value="Enregistrer">
                </form>
            </div>
        </div>
    </section>
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
            <th scope="col">DISPONIBILITE</th>
            <th scope="col">ACTION</th>
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
                    <td class ="$availableClass">$available</td>
                    <td>
                        <div>
                            <a href="#">Editer</a>
                            <a href="#">Supprimer</a>
                        </div>
                    </td>
                </tr>
            HTML;
            echo $booksTable;
        }
        ?>
    </tbody>
</table>
<a href=""></a>