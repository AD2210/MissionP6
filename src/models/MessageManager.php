<?php
//@todo vérifier si je ne peux pas opitmiser certaines requetes pour limiter le nombre de data transféré
require_once 'DBManager.php';
require_once 'Message.php';
class MessageManager
{
    public function getAllMessages(): array
    {
        $sql = "SELECT * FROM message";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, "message");
    }

    public function getAllMessagesByIdReceiver(int $idReceiver): array
    {
        $sql = "SELECT * FROM message WHERE id = $idReceiver"; // @todo préparer la requette
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_CLASS, "message");
        return $result->fetchAll();
    }

    public function getLastMessagesFromEachSenderByIdReceiver(int $idReceiver): array //tri a faire
    {
        $sql = "SELECT * FROM message WHERE id = $idReceiver"; // @todo préparer la requette
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_CLASS, "message");
        return $result->fetchAll();
    }

    public function getOneMessageById(int $id): Message
    {
        $sql = "SELECT * FROM message WHERE id = $id"; // @todo préparer la requette
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_CLASS, "message");
        return $result->fetch();
    }

    public function addNewMessage(Message $message): void //@todo faire les contrôles de saisie dans l'entité
    {
        $sql = "INSERT INTO message (idSender, idReceiver, content, sendDate, readFlag) 
            VALUES (:idSender, :idReceiver, :content, NOW(), 0)";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idSender' => $message->getIdSender(),
            'idReceiver' => $message->getIdReceiver(),
            'content' => $message->getContent()
        ]);
    }

}