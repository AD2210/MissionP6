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
    private DateTime|string $sendDate;
    private bool $readFlag;

    public function __construct(){
        if (is_string($this->sendDate)){
            $this->sendDate = new DateTime($this->sendDate);
        }
    }
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

    public function getContent(int $length = -1): string
    {
        if ($length > 0) {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux (caractère multibyte comme les accents).
            $content = mb_substr($this->content, 0, $length);
            if (strlen($this->content) > $length) {
                $content .= "...";
            }
            return $content;
        }
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

    public function setSendDate(DateTime|string $sendDate): void
    {
        if (is_string($this->sendDate)){
            $this->sendDate = new DateTime($this->sendDate);
        }else{
            $this->sendDate = $sendDate;
        }
    }

    public function getReadFlag(): bool
    {
        return $this->readFlag;
    }

    public function setReadFlag(bool $readFlag): void
    {
        $this->readFlag = $readFlag;
    }

    //Formater de date

    public function getSendDateStringFormat(string $format) : string {
        return date_format($this->sendDate,$format);
    }
}