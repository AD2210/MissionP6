<?php
/**
 * Classe permettant les échanges en BDD de l'entité Book
 */
require_once 'DBManager.php';
require_once 'Book.php';

class BookManager
{
    /**
     * Requête renvoyant tous les livres présent en BDD
     * @return array
     */
    public function getAllBooks(): array
    {
        $sql = "SELECT * FROM book";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS,Book::class);
    }

    /**
     * Requête renvoyant tous les livres appartenant à un membre grace à son id User
     * @param int $idMember
     * @return array
     */
    public function getAllBooksByIdMember(int $idMember): array
    {
        $sql = "SELECT * FROM book WHERE idMember = :idMember";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idMember' => $idMember
        ]);
        return $result->fetchAll(PDO::FETCH_CLASS,Book::class);
    }

    /**
     * Requête renvoyant les 4 derniers livres enregistré en BDD
     * @return array
     */
    public function getFourLastBooks(): array
    {
        $sql = "SELECT * FROM book ORDER BY id DESC LIMIT 4";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS,Book::class);
    }

    /**
     * Requête renvoyant le dernier id Book utilisé
     * @return int
     * @annotation Methode utilisé pour le fonctionnement des fixtures
     */
    public function getLastBookId() : int {
        //Requête pour sortir le dernier ID utilisé
        $sql = 'SELECT id FROM book';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $array = $result->fetchAll();
        
        return $array[count($array)-1]['id'];
    }

    /**
     * Requête renvoyant un livre grâce son id
     * @param int $id
     * @return Book
     */
    public function getOneBookById(int $id): Book
    {
        $sql = "SELECT * FROM book WHERE id = :id" ;
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'id' => $id
        ]);
        $result->setFetchMode(PDO::FETCH_CLASS,Book::class);
        return $result->fetch();
    }

    /**
     * Requête permettant d'ajouter en BDD un nouveau livre
     * @param Book $book
     * @return void
     */
    public function addNewBook(Book $book): void //@todo faire les contrôles de saisie dans l'entité
    {
        $sql = "INSERT INTO book (title, author, comment, available, idMember, picture) 
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