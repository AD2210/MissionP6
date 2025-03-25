<?php

/**
 * Entité User, défini par les champs :
 * id : identifiant unique du membre , défini dans class abstraite
 * pseudo : pseudonyme du membre
 * avatar : lien vers image représentant le membre
 * email : email du membre
 * password : mot de passe
 * registerDate : date d'inscription
 */

// Permet la création dynamique d'objet lors des requetes en bdd en affectant les noms de table aux attributs de l'objet User
#[\AllowDynamicProperties]
class User
{
    private int $id = -1;
    private string $pseudo;
    private ?string $avatar;
    private string $email;
    private string $password;
    private DateTime|string $registerDate ='';

    /**
     * Contructeur de classe 
     * ce constructeur permet de convertir la date du string issu de la BDD en objet 
     * DateTime lors de la création dynamique pendant l'exécution des requêtes
     */
    public function __construct(){
        if (is_string($this->registerDate)){
            $this->registerDate = new DateTime($this->registerDate);
        }
    }

    /**
     * Getter id utilisateur
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Setter id utilisateur
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Getter pseudo utilisateur
     * @return string
     */
    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    /**
     * Setter pseudo utilisateur
     * @param string $pseudo
     * @return void
     */
    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }

    /**
     * Getter avatar utilisateur sous forme d'url
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * Setter avatar utilisateur sous forme d'url
     * @param mixed $avatar
     * @return void
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * Getter email utilisateur
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Setter email utilisateur
     * @param string $email
     * @return void
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * Getter mot de passe utilisateur, on conserve le hash et l'on renvoie 8 caractères quelque soit la longueur du mot de passe
     * @todo attention à la vérification MP
     * @return string
     */
    public function getPassword(): string
    {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux (caractère multibyte comme les accents).
            //$content = mb_substr($this->password, 0, 8);
            return $this->password;
    }

    /**
     * Setter mot de passe utilisateur, le mot est hasher lors de l'enristrement de l'attribut
     * @param string $password
     * @return void
     */
    public function setPassword(string $password): void
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Getter date d'inscription de l'utilisateur
     * @return DateTime
     */
    public function getRegisterDate(): DateTime
    {
        return $this->registerDate;
    }

    /**
     * Setter date d'inscription de l'utilisateur
     * En fonction du format d'entrée, permet de transformer le string en DateTime
     * @param DateTime|string $registerDate
     * @return void
     */
    public function setRegisterDate(DateTime|string $registerDate): void
    {
        if (is_string($this->registerDate)){
            $this->registerDate = new DateTime($this->registerDate);
        }else{
            $this->registerDate = $registerDate;
        }
    }
}