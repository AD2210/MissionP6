<section class="oursBooksSection">
    <div class="oursBooksContainer">
        <div class="SectionTitle">
            <h1>Nos livres à l’échange</h1>
            <div class="searchBar">
                <img src="ressources\icon search.png" alt="icone recherche">
                <input type="search" name="bookSearch" id="bookSearch" placeholder="Rechercher un livre">
            </div>
        </div>
        <div class="bookCardsContainer">
            <?php foreach ($books as $book) {
                //Variable pour HereDoc
                $id = $book->getId();
                $title = $book->getTitle();
                $author = $book->getAuthor();
                $picture = $book->getPicture();
                $pseudo = $userManager
                    ->getOneUserById($book->getIdMember())
                    ->getPseudo();

                //Bloc d'affichage
                $bookCard = <<<HTML
                    <a href="index.php?action=oneBook&id=$id">
                        <article class="bookCard">
                            <img src="$picture" alt="photo d'un livre">
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