<?php
// variable pour HereDoc
$title = $book->getTitle();
$picture = $book->getPicture();
$author = $book->getAuthor();
$decription = $book->getMessage();
//$avatar = $user->getAvatar();
//$pseudo = $book->getIdMember();

$dynamicLink = <<<HTML
    <div>
        <span><a href="#">← retour</a></span>
        <h1>Modifier les informations</h1>
    </div>
    <section class="oneBookSection">
        <p>Photo</p>
        <img src="$picture" alt="photo du livre : $title">
        <a href="#">Modifier la photo</a>
        <form action="#">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title">
            <label for="author">Auteur</label>
            <input type="text" name="author" id="author">
            <label for="comment">Commentaire</label>
            <input type="text" name="comment" id="comment">
            <label for="availability">Disponibilité</label>
            <input list="availability-choice" name="availability" id="availability"/>
            <datalist id="availability-choice">
                <option value="disponible"></option>
                <option value="non dispo."></option>
            </datalist>
            <button type="submit">Valider</button>
        </form>
    </section>
    HTML;

    echo $dynamicLink;
