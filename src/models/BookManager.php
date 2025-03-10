<?php
require_once 'DBManager.php';
require_once 'Book.php';
class BookManager
{
    public function getAllBooks(): array
    {
        $sql = "SELECT * FROM book";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS,"book");
    }

    public function getFourLastBooks(): array
    {
        $sql = "SELECT * FROM book ORDER BY id DESC LIMIT 4";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS,"book");
    }

    public function getLastBookId() : int {
        //Requête pour sortir le dernier ID utilisé
        $sql = 'SELECT id FROM book';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $array = $result->fetchAll();
        
        return $array[count($array)-1]['id'];
    }

    public function getOneBookById(int $id): Book
    {
        $sql = "SELECT * FROM book WHERE id = $id" ;
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_CLASS,"book");
        return $result->fetch();
    }

    public function addNewBook(Book $book): void //@todo faire les contrôles de saisie dans l'entité
    {
        $sql = "INSERT INTO book (title, author, comment, available, id_member, picture) 
            VALUES (:title, :author, :comment, :available, :idMember, :picture)";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'title' => $book->getTitle(),
            'author' => $book->getAuthor(),
            'comment' => $book->getComment(),
            'available' => $book->getAvailable(),
            'idMember' => $book->getIdMember(),
            'picture' => $book->getPicture()
        ]);
    }
}