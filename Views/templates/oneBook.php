<?php
// variable pour HereDoc
$title = $book->getTitle();
$picture = $book->getPicture();
$author = $book->getAuthor();
$decription = $book->getMessage();
//$avatar = $member->getAvatar();
//$pseudo = $book->getIdMember();

$dynamicLink = <<<HTML
    <div>
        <span><a href="#">Nos livres</a> > <a href="#">$title</a></span>
    </div>
    <section class="oneBookSection">
        <img src="$picture" alt="photo du livre : $title">
        <div class="oneBookContainer">
            <h1>$title</h1>
            <p>par $author</p>
            <p>___</p>
            <p>DESCRIPTION</p>
            <p>$decription</p>
            <p>PROPRIÉTAIRE</p>
            <div class="ownerCard">
                <img src="$avatar" alt="photo du membre : $pseudo">
                <p>$pseudo</p>
            </div>
            <button type="submit">Envoyer un message</button>
        </div>
    </section>
    HTML;

    echo $dynamicLink;
