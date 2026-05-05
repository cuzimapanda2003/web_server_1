<?php

class Commentaire
{
    private int $id;
    private string $texte;
    private ?DateTime $datePublication;
    private int $auteurId; // L'id de l'utilisateur qui a écrit le commentaire
    private ?Utilisateur $auteur; // L'utilisateur qui a écrit le commentaire
    private int $articleId; // L'id de l'article sur lequel porte le commentaire

    public function __construct(string $texte, int $auteurId, int $articleId, ?DateTime $datePublication = null, int $id = 0)
    {
        $this->setId($id);
        $this->setTexte($texte);
        $this->setDatePublication($datePublication);
        $this->setAuteurId($auteurId);
        $this->setArticleId($articleId);
        $this->setAuteur(null);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTexte(): string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $texte = trim($texte);
        if (empty($texte) || mb_strlen($texte, 'UTF-8') > 65535)
            throw new InvalidArgumentException("Le texte '$texte' doit être entre 1 et 65535 caractères.");
        $this->texte = $texte;
        return $this;
    }

    public function getDatePublication(): ?DateTime
    {
        return $this->datePublication;
    }

    public function setDatePublication(?DateTime $datePublication): self
    {
        $this->datePublication = $datePublication;
        return $this;
    }

    public function getAuteurId(): int
    {
        return $this->auteurId;
    }

    public function setAuteurId(int $auteurId): self
    {
        $this->auteurId = $auteurId;
        return $this;
    }

    public function getAuteur(): ?Utilisateur
    {
        return $this->auteur;
    }

    public function setAuteur(?Utilisateur $auteur): self
    {
        $this->auteur = $auteur;
        return $this;
    }

    public function getArticleId(): int
    {
        return $this->articleId;
    }

    public function setArticleId(int $articleId): self
    {
        $this->articleId = $articleId;
        return $this;
    }
}
