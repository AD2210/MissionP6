<?php
/**
 * Classe permettant les échanges en BDD de l'entité Message
 */
require_once 'DBManager.php';
require_once 'Message.php';
class MessageManager
{
    /**
     * Requête renvoyant tous les messages présent en BDD
     * @return array
     */
    public function getAllMessages(): array
    {
        $sql = "SELECT * FROM message";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, Message::class);
    }

    /**
     * Requête renvoyant tous les messages d'un fil de discussion en 2 Users
     * le user connecté et le user du fil selectionné
     * @param int $idReceiver
     * @param int $idSender
     * @return array
     */
    public function getAllMessagesByIdReceiverAndIdSender(int $idReceiver, int $idSender): array
    {
        $sql = "SELECT * FROM message WHERE (idReceiver = :idReceiver AND idSender = :idSender) OR
         (idReceiver = :idSender AND idSender = :idReceiver) ORDER BY id ASC";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idReceiver' => $idReceiver,
            'idSender' => $idSender
        ]);
        $result->setFetchMode(PDO::FETCH_CLASS, Message::class);
        return $result->fetchAll();
    }

    /**
     * Requête renvoyant un message grâce a son id
     * @param int $id
     * @return Message
     */
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

    /**
     * Requête permettant d'ajouter en BDD un nouveau message
     * @param Message $message
     * @return void
     */
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