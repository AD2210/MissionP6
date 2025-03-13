<?php
/**
 * Entité message, définit par les champs :
 * id : identifiant du message
 * idSender : id du membre qui a envoyé le message
 * idReceiver : id du membre qui a reçu le message
 * content : contenu du message
 * sendDate : date d'envoi au format jj.mm HH:mm
 * readFlag : bool pour savoir si le message a été lu ou non
 */

 #[\AllowDynamicProperties]
class Message
{
    private int $id;
    private int $idSender;
    private int $idReceiver;
    private string $content;
    private DateTime $sendDate;
    private bool $readFlag;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getIdSender(): int
    {
        return $this->idSender;
    }

    public function setIdSender(int $idSender): void
    {
        $this->idSender = $idSender;
    }
    public function getIdReceiver(): int
    {
        return $this->idReceiver;
    }

    public function setIdReceiver(int $idReceiver): void
    {
        $this->idReceiver = $idReceiver;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }
    public function getSendDate(): DateTime
    {
        return $this->sendDate;
    }

    public function setSendDate(DateTime $sendDate): void
    {
        $this->sendDate = $sendDate;
    }

    public function getReadFlag(): bool
    {
        return $this->readFlag;
    }

    public function setReadFlag(bool $readFlag): void
    {
        $this->readFlag = $readFlag;
    }
}