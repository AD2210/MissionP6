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

// Permet la création dynamique d'objet lors des requetes en bdd en affectant les noms de table aux attributs de l'objet Message
#[\AllowDynamicProperties]
class Message
{
    private int $id;
    private int $idSender;
    private int $idReceiver;
    private string $content;
    private DateTime|string $sendDate = '';
    private bool $readFlag;

    /**
     * Contructeur de classe 
     * ce constructeur permet de convertir la date en format string issu de la BDD en objet 
     * DateTime lors de la création dynamique pendant l'exécution des requêtes
     */
    public function __construct()
    {
        if (is_string($this->sendDate)) {
            $this->sendDate = new DateTime($this->sendDate);
        }
    }

    /**
     * Getter id message
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Setter id message
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Getter id User du l'emmetteur du message
     * @return int
     */
    public function getIdSender(): int
    {
        return $this->idSender;
    }

    /**
     * Setter id User du l'emmetteur du message
     * @param int $idSender
     * @return void
     */
    public function setIdSender(int $idSender): void
    {
        $this->idSender = $idSender;
    }

    /**
     * Getter id User du destinataire du message
     * @return int
     */
    public function getIdReceiver(): int
    {
        return $this->idReceiver;
    }

    /**
     * Setter id User du destinataire du message
     * @param int $idReceiver
     * @return void
     */
    public function setIdReceiver(int $idReceiver): void
    {
        $this->idReceiver = $idReceiver;
    }

    /**
     * Getter contenu du message
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Setter contenu du message, on contrôle la faille XSS ici en excluant les caratères spéciaux
     * @param string $content
     * @return void
     */
    public function setContent(string $content): void
    {
        $this->content = htmlspecialchars($content);
    }

    /**
     * Getter date d'envoi du message
     * @return DateTime
     */
    public function getSendDate(): DateTime
    {
        return $this->sendDate;
    }

    /**
     * Setter date d'envoi du message
     * En fonction du format d'entrée, permet de transformer le string en DateTime
     * @param DateTime|string $sendDate
     * @return void
     */
    public function setSendDate(DateTime|string $sendDate): void
    {
        if (is_string($this->sendDate)) {
            $this->sendDate = new DateTime($this->sendDate);
        } else {
            $this->sendDate = $sendDate;
        }
    }

    /**
     * Getter du bit message Lu, le message est lu si le bit est à true
     * @return bool
     */
    public function getReadFlag(): bool
    {
        return $this->readFlag;
    }

    /**
     * Setter du bit message Lu, le message est lu si le bit est à true
     * @param bool $readFlag
     * @return void
     */
    public function setReadFlag(bool $readFlag): void
    {
        $this->readFlag = $readFlag;
    }

}