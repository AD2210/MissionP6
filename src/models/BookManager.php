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

    public function getOneBookById(int $id): Book
    {
        $sql = "SELECT * FROM book WHERE id = $id" ;
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $result = $pdo->setAttribute(PDO::FETCH_CLASS,"book");
        return $result->fetch();
    }
}