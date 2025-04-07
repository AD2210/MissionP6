<?php
/**
 * Template du formulaire d'edition d'un livre, accessible depuis l'espace privé
 */

// variable pour HereDoc conditionné si création ou edition
if ($create){
    $id = '';
    $title = '';
    $picture = 'https://preview.free3d.com/img/2016/08/1851631529512404705/bvxq8qpk.jpg	'; //image par défaut
    $author = '';
    $comment = '';
    $available = true;
    $availableClass = $available ? '' : 'selected'; //permet de selectionner la valeur par défaut de la liste déroulante
    $formAction = "index.php?action=createBook";
}else{
    $id = $book->getId();
    $title = $book->getTitle();
    $picture = $book->getPicture();
    $author = $book->getAuthor();
    $comment = $book->getComment();
    $available = $book->getAvailable();
    $availableClass = $available ? '' : 'selected'; //permet de selectionner la valeur par défaut de la liste déroulante
    $formAction = "index.php?action=updateBook&id=$id";
}

//Bloc d'affichage
$bookForm = <<<HTML
    <section class="editBookSection">
        <div class="editBookMainContainer">
            <div>
                <span><a href="index.php?action=privatePage">← retour</a></span>
                <h1>Modifier les informations</h1>
            </div>
            <div class="editBookContainer">
                <div class="editPictureContainer">
                    <p>Photo</p>
                    <img src="$picture" alt="photo du livre : $title">
                    <a role="link" aria-disabled="true">Modifier la photo</a>
                </div>
                <form class="editBookForm" action="$formAction" method="POST">
                    <input type="hidden" name="id" value="$id">
                    <div class="formField">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" value="$title">
                    </div>
                    <div class="formField">
                        <label for="author">Auteur</label>
                        <input type="text" name="author" id="author" value="$author">
                    </div>
                    <div class="formField">
                        <label for="comment">Commentaire</label>
                        <textarea name="comment" id="comment" rows="20">$comment</textarea>
                    </div>
                    <div class="formField">
                        <label for="availability">Disponibilité</label>
                        <select id="availability" name="availability">
                            <option value="1">disponible</option>
                            <option value="0" $availableClass>non dispo.</option>
                        </select>
                    </div>
                    <button class ="button" type="submit">Valider</button>
                </form>
            </div>
        </div>
    </section>
    HTML;

echo $bookForm;
