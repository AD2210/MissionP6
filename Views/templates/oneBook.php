<?php
// variable pour HereDoc
$title = $book->getTitle();
$picture = $book->getPicture();
$author = $book->getAuthor();
$decription = $book->getComment();
$avatar = $user->getAvatar();
$pseudo = $user->getPseudo();
$idUser = $user->getId();

$dynamicLink = <<<HTML
    <div class="navLinkContainer">
        <div class="navLink">
            <span ><a href="index.php?action=allBooks">Nos livres</a> > $title</span>
        </div>
    </div>
    <section class="oneBookSection">
        <div class="oneBookMainContainer">
            <img src="$picture" alt="photo du livre : $title">
            <div class="oneBookContainer">
                <h1>$title</h1>
                <span>par $author</span>
                <span class="separator">——</span>
                <p class="partTitle">DESCRIPTION</p>
                <p class="bookDescription">$decription</p>
                <p class="partTitle">PROPRIÉTAIRE</p>
                <a href="index.php?action=publicPage&id=$idUser">
                    <div class="ownerCard">
                        <img src="$avatar" alt="photo du membre : $pseudo">
                        <p>$pseudo</p>
                    </div>
                </a>
                <a href="index.php?action=messaging&corresponding=$idUser">
                    <div class="button">Envoyer un message</div>
                </a>
            </div>
        </div>
    </section>
    HTML;

    echo $dynamicLink;
