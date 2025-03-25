<?php
// variable pour HereDoc
$id = $book->getId();
$title = $book->getTitle();
$picture = $book->getPicture();
$author = $book->getAuthor();
$comment = $book->getComment();
$available = $book->getAvailable();
$availableClass = $available ? '' : 'selected'; //permet de selectionner la valeur par défaut

$dynamicLink = <<<HTML
    <div>
        <span><a href="index.php?action=privatePage">← retour</a></span>
        <h1>Modifier les informations</h1>
    </div>
    <section class="oneBookSection">
        <p>Photo</p>
        <img src="$picture" alt="photo du livre : $title">
        <a href="#">Modifier la photo</a>
        <form action="index.php?action=updateBook&id=$id">
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="$title">
            <label for="author">Auteur</label>
            <input type="text" name="author" id="author" value="$author">
            <label for="comment">Commentaire</label>
            <input type="text" name="comment" id="comment" value="$comment">
            <label for="availability">Disponibilité</label>
            <select id="availability" name="availaibilityChoice">
                <option value="true">disponible</option>
                <option value="false" $availableClass>non dispo.</option>
            </select>
            <button type="submit">Valider</button>
        </form>
    </section>
    HTML;

    echo $dynamicLink;
