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
        return $result->fetchAll(PDO::FETCH_CLASS, Message::class);
    }

    public function getAllMessagesByIdReceiver(int $idReceiver): array
    {
        $sql = "SELECT * FROM message WHERE idReceiver = :idReceiver";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idReceiver' => $idReceiver
        ]);
        $result->setFetchMode(PDO::FETCH_CLASS, Message::class);
        return $result->fetchAll();
    }

    public function getLastMessagesFromEachSenderByIdReceiver(int $idReceiver): array
    {   // On utilise DISTINCT pour n'avoir que 1 message par correspondant, le fait de les trié par date permet d'avoir le dernier message
        $sql = "SELECT DISTINCT idSender, id, content, sendDate, readFlag FROM message WHERE idReceiver = :idReceiver ORDER BY sendDate DESC";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idReceiver' => $idReceiver
        ]);
        $result->setFetchMode(PDO::FETCH_CLASS, Message::class);
        return $result->fetchAll();
    }

    static public function getLastMessagesFromOneSenderByIdReceiver(int $idSender, int $idReceiver): Message
    {
        $sql = "SELECT * FROM message WHERE idReceiver = :idReceiver AND idSender = :idSender  ORDER BY sendDate DESC LIMIT 1";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idReceiver' => $idReceiver,
            'idSender' => $idSender
        ]);
        $result->setFetchMode(PDO::FETCH_CLASS, Message::class);
        return $result->fetch();
    }

    public function getAllMessagesByIdReceiverAndIdSender(int $idReceiver, int $idSender): array
    {
        $sql = "SELECT * FROM message WHERE idReceiver = :idReceiver AND idSender = :idSender ORDER BY id DESC";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idReceiver' => $idReceiver,
            'idSender' => $idSender
        ]);
        $result->setFetchMode(PDO::FETCH_CLASS, Message::class);
        return $result->fetchAll();
    }

    public function getOneMessageById(int $id): Message
    {
        $sql = "SELECT * FROM message WHERE id = :id";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'id' => $id
        ]);
        $result->setFetchMode(PDO::FETCH_CLASS, Message::class);
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