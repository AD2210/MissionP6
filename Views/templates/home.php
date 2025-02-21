<?php
/**
 * Affichage de La page d'accueil. 
 */
 include 'templates/main.php';
?>

<section>
    <h1>Rejoignez nos lecteurs passionnés</h1>
    <p>Donnez une nouvelle vie à vos livres en les échangeant avec d'autres amoureux de la lecture. Nous croyons en la
        magie du partage de connaissances et d'histoires à travers les livres.</p>
    <button type="button">Découvrir</button>
    <img src="\ressources\e67398fca2185c7e020225c880309454.jpeg"
        alt="Homme lisant un livre autour de plusieurs piles de livres">
</section>
<section>
    <h2>Les derniers livres ajoutés</h2>
    <div>
        <? foreach ($books as $book) { ?>
            <article>
                <img src="#" alt="photo d'un livre">
                <h3>titre</h3>
                <h4>Auteur</h4>
                <p>Vendu par : pseudo</p>
            </article>
        <? } ?>
    </div>
    <button type="button">Voir tous les livres</button>
</section>
<section>
    <h2>Comment ça marche ?</h2>
    <p>Échanger des livres avec TomTroc c’est simple et amusant ! Suivez ces étapes pour commencer :</p>
    <div>
        <div>
            <p>Inscrivez-vous gratuitement sur notre plateforme.</p>
        </div>
        <div>
            <p>Ajoutez les livres que vous souhaitez échanger à votre profil.</p>
        </div>
        <div>
            <p>Parcourez les livres disponibles chez d'autres membres.</p>
        </div>
        <div>
            <p>Proposez un échange et discutez avec d'autres passionnés de lecture.</p>
        </div>
    </div>
    <button type="button">Voir tous les livres</button>
</section>
<section>
    <img src="\ressources\4c3f0a4a254acb5010dd96d3fb7321e4.jpeg" alt="Femme cherchant un livre dans une bibliothèque">
</section>
<section>
    <h3>Nos valeurs</h3>
    <p>Chez Tom Troc, nous mettons l'accent sur le partage, la découverte et la communauté. Nos valeurs sont ancrées
        dans notre passion pour les livres et notre désir de créer des liens entre les lecteurs. Nous croyons en la
        puissance des histoires pour rassembler les gens et inspirer des conversations enrichissantes. Notre association
        a été fondée avec une conviction profonde : chaque livre mérite d'être lu et partagé. Nous sommes passionnés par
        la création d'une plateforme conviviale qui permet aux lecteurs de se connecter, de partager leurs découvertes
        littéraires et d'échanger des livres qui attendent patiemment sur les étagères.</p>
    <p>L’équipe Tom Troc</p>
    <img src="\ressources\coeur.png" alt="Coeur dessiné au crayon">
</section>