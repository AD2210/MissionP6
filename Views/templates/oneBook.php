<?php
// variable pour HereDoc
$title = $book->getTitle();
$picture = $book->getPicture();
$author = $book->getAuthor();
$decription = $book->getComment();
$avatar = $user->getAvatar();
$pseudo = $user->getPseudo();

$dynamicLink = <<<HTML
    <div class="navLink">
        <span ><a href="#">Nos livres</a> > <a href="#">$title</a></span>
    </div>
    <section class="oneBookSection">
        <img src="$picture" alt="photo du livre : $title">
        <div class="oneBookContainer">
            <h1>$title</h1>
            <span>par $author</span>
            <span>——</span>
            <p class="partTitle">DESCRIPTION</p>
            <p class="bookDescription">$decription</p>
            <p class="partTitle">PROPRIÉTAIRE</p>
            <div class="ownerCard">
                <img src="$avatar" alt="photo du membre : $pseudo">
                <p>$pseudo</p>
            </div>
            <button type="submit">Envoyer un message</button>
        </div>
    </section>
    HTML;

    echo $dynamicLink;
