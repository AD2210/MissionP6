<?php
/**
 * Template de la partie tous les livres à l'échange
 */

?>
<section class="oursBooksSection">
    <div class="oursBooksContainer">
        <div class="SectionTitle">
            <h2>Nos livres à l’échange</h2>
            <form class="searchBar" action="index.php?action=allBooks" method="POST">
                <label for="bookSearch"><img src="ressources/iconSearch.png" alt="icone recherche"></label>
                <input type="search" name="bookSearch" id="bookSearch" placeholder="Rechercher un livre">
            </form>
        </div>
        <div class="bookCardsContainer">
            <?php foreach ($books as $book) {
                //Variable pour HereDoc, on recupère les informations du livre à afficher
                $id = $book->getId();
                $title = $book->getTitle();
                $author = $book->getAuthor();
                $picture = $book->getPicture();
                $available = $book->getAvailable() ? '' : 'non dispo.';
                $availableClass = $book->getAvailable() ? 'HideAvailable' : 'unavailable';
                $pseudo = $userManager
                    ->getOneUserById($book->getIdMember())
                    ->getPseudo();

                //Bloc d'affichage
                $bookCard = <<<HTML
                    <a href="index.php?action=oneBook&id=$id">
                        <article class="bookCard">
                            <div class="pictureAllBook">
                                <img src="$picture" alt="photo d'un livre">
                                <div class ="bookStatus $availableClass">$available</div>
                            </div>    
                            <div class="bookCardText">
                                <h3>$title</h3>
                                <h4>$author</h4>
                                <p>Vendu par : $pseudo</p>
                            </div>
                        </article>
                    </a>    
                HTML;
                echo $bookCard;
            } ?>
        </div>
    </div>
</section>
