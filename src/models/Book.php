<?php
/**
 * Entité book, défini par les champs:
 * id : identifiant unique du livre
 * title : Titre du livre
 * author : auteur du livre
 * comment : avis sur le livre
 * available : disponibilité du livre Vrai / Faux
 * idMember : id du proriétaire du livre
 * picture : lien vers l'image du livre
 */

// Permet la création dynamique d'objet lors des requetes en bdd en affectant les noms de table aux attributs de l'objet Book
#[\AllowDynamicProperties]
class Book
{
    private int $id;
    private string $title;
    private string $author;
    private string $comment;
    private bool $available;
    private int $idMember;
    private string $picture;

    /**
     * Getter id libre
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Setter id livre
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Getter titre du Livre
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Setter titre du livre, on contrôle ici la faille XSS en excluant les caractères spéciaux
     * @param string $title
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = htmlspecialchars($title);
    }

    /**
     * Getter auteur du livre
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Setter auteur du livre,on contrôle ici la faille XSS en excluant les caractères spéciaux
     * @param string $author
     * @return void
     */
    public function setAuthor(string $author): void
    {
        $this->author = htmlspecialchars($author);
    }

    /**
     * Getter commentaire sur le livre
     * renvoie le commentaire tronquer si necessaire en precisant le nombre de caratères à renvoyer
     * @param int $length
     * @return string
     */
    public function getComment(int $length = 0): string
    {
        if ($length > 0) {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux (caractère multibyte comme les accents).
            $content = mb_substr($this->comment, 0, $length);
            if (strlen($this->comment) > $length) {
                $content .= "...";
            }
            return $content;
        }
        return $this->comment;
    }

    /**
     * Setter commentaire sur le livre, on contrôle ici la faille XSS en excluant les caractères spéciaux
     * @param string $comment
     * @return void
     */
    public function setComment(string $comment): void
    {
        $this->comment = htmlspecialchars($comment);
    }

    /**
     * Getter disponibilité du livre
     * @return bool
     */
    public function getAvailable(): bool
    {
        return $this->available;
    }

    /**
     * Setter disponibilité du livre
     * @param bool $available
     * @return void
     */
    public function setAvailable(bool $available): void
    {
        $this->available = $available;
    }

    /**
     * Getter id User du propriétaire du livre
     * @return int
     */
    public function getIdMember(): int
    {
        return $this->idMember;
    }

    /**
     * Setter id User du propriétaire du livre
     * @param int $idMember
     * @return void
     */
    public function setIdMember(int $idMember): void
    {
        $this->idMember = $idMember;
    }

    /**
     * Getter photo du livre sous forme d'url
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * Setter photo du livre sous forme d'url
     * @param string $picture
     * @return void
     */
    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }
}