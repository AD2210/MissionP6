<?php
require_once 'DBManager.php';
require_once 'Book.php';
class BookManager
{
    public function getAllbooks(): array
    {
        $sql = "SELECT * FROM book";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS,"book");
    }
}