<?php
/**
 * Class de création de données fictives dans la base
 */
require_once('BookManager.php');
require_once('MessageFixture.php');

class BookFixture
{

    /**
     * Methode pour créer un livre fictif
     * @return void
     */
    function createOneBook(): void
    {
        $bookManager = new BookManager;
        $book = new Book;

        //Utilisation de l'API Picsum pour généré un nom d'auteur
        $title = 'https://picsum.photos/id/' .random_int(2,40) . '/info';
        $title = json_decode(file_get_contents($title), JSON_OBJECT_AS_ARRAY)['author'];
        $author = 'https://picsum.photos/id/' .random_int(41,84) . '/info';
        $author = json_decode(file_get_contents($author), JSON_OBJECT_AS_ARRAY)['author'];

        // Affectation des datas fictives pour allimenter la bdd durant le developpement
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setComment('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac leo vitae dolor feugiat convallis. 
    Proin sagittis ex in est varius tempus. Phasellus pretium, velit sed rhoncus sagittis, lacus justo dignissim libero, 
    in pellentesque eros eros vitae mi. Suspendisse vel condimentum magna. Sed ultrices auctor mi, quis accumsan lectus finibus id. 
    Aenean libero purus, finibus eget leo luctus, iaculis interdum velit. Curabitur eget lectus diam. Vivamus at tristique lorem. 
    Integer vestibulum cursus neque sit amet gravida.

    Mauris non velit in felis vehicula feugiat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.
     Vivamus luctus, turpis et porta consequat, ex ipsum mattis libero, sed consectetur neque ipsum et ligula. 
     Donec ut risus molestie erat suscipit finibus. Sed gravida mauris lectus, eu egestas ante mattis id. 
     Sed ante sapien, posuere eget neque a, rhoncus gravida ligula. Maecenas convallis vestibulum placerat.');
        $book->setAvailable(random_int(0, 1));
        $book->setIdMember(MessageFixture::randId());
        $book->setPicture('https://picsum.photos/900?random=' . $bookManager->getLastBookId() + 1);


        //on enregistre en BDD
        $bookManager->addNewBook($book);
    }

    /**
     * Methode pour créer en lot des books
     * @param int $nb
     * @return void
     */
    function createSomeBooks(int $nb): void
    {
        for ($i = 0; $i < $nb; $i++) {
            $fixture = new bookFixture;
            $fixture->createOneBook();
        }
    }
}