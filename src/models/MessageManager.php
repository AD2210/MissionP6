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
     * Requête renvoyant le nombre de message non lu de l'utilisateur connecté pour affichage dans la barNav
     * @param int $idReceiver
     * @return int
     */
    public function getNumberOfMessagesByIdReceiver(int $idReceiver): int
    {
        $sql = "SELECT id FROM message WHERE idReceiver = :idReceiver And readFlag = 0";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idReceiver' => $idReceiver
        ]);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        return count($result->fetchAll());
    }

    /**
     * Requête renvoyant tous les messages d'un fil de discussion entre 2 Users
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
     * Requête multi table renvoyant les derniers messages envoyés à un utilisateur donnés
     * agrégé avec les données des utilisateurs ayant envoyé chacun des messages
     * @param int $idReceiver
     * @return array
     */
    public function getAllUsersAndMessageByLastMessage(int $idReceiver): array
    {
        $sql = 'SELECT 
            u.id AS user_id,
            u.avatar,
            u.pseudo,
            m.id AS message_id,
            m.content,
            m.idSender,
            m.sendDate,
            m.readFlag
            FROM (
                SELECT 
                    CASE 
                        WHEN idSender = :current_user_id THEN idReceiver
                        ELSE idSender
                    END AS contact_id,
                    MAX(sendDate) AS last_message_date
                FROM message
                WHERE idReceiver = :current_user_id OR idSender = :current_user_id
                GROUP BY contact_id
            ) AS latest
            JOIN message m 
                ON ((m.idSender = :current_user_id AND m.idReceiver = latest.contact_id)
                OR (m.idSender = latest.contact_id AND m.idReceiver = :current_user_id))
                AND m.sendDate = latest.last_message_date
            JOIN user u ON u.id = latest.contact_id
            ORDER BY m.sendDate DESC;';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'current_user_id' => $idReceiver
        ]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Requête renvoyant l'id du dernier correspondant, renvoi 0 si la messagerie est vide
     * @param int $idReceiver
     * @return int
     */
    public function getLastIdSenderByIdReceiverFromLastMessage(int $idReceiver): int
    {
        $sql = 'SELECT idSender, idReceiver, MAX(sendDate) FROM message WHERE idReceiver = :idReceiver OR idSender = :idReceiver GROUP BY idSender ORDER BY sendDate DESC';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idReceiver' => $idReceiver
        ]);
        $array = $result->fetch(PDO::FETCH_ASSOC);

        if (empty($array)) {
            return 0;
        }
        $corresponding = $idReceiver == $array['idSender'] ? $array['idReceiver'] : $array['idSender'];
        return $corresponding;
    }

    /**
     * Requête permettant de mettre à jour le status Lu d'un message
     * @param int $idSender
     * @return void
     */
    public function updateReadflag(int $idSender): void
    {

        $sql = 'UPDATE message SET readFlag = 1 WHERE idSender = :idSender';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idSender' => $idSender
        ]);
    }

    /**
     * Requête permettant d'ajouter en BDD un nouveau message
     * @param Message $message
     * @return void
     */
    public function addNewMessage(Message $message): void
    {
        $sql = "INSERT INTO message (idSender, idReceiver, content, sendDate, readFlag) 
            VALUES (:idSender, :idReceiver, :content, :sendDate, 0)";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'idSender' => $message->getIdSender(),
            'idReceiver' => $message->getIdReceiver(),
            'content' => $message->getContent(),
            'sendDate' => $message->getSendDate()->format('Y-m-d H:i:s')
        ]);
    }

}