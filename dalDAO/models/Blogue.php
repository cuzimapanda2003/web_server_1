<?php

class Blogue
{
    private int $id;
    private string $nom;
    private string $description;
    private ?DateTime $dateCreation;
    private int $blogueurId;
    private ?Utilisateur $blogueur;
    private array $articles;

    public function __construct(
        string $nom,
        string $description,
        int $blogueurId,
        ?DateTime $dateCreation = null,
        int $id = 0
    )
    {
        $this->setId($id);
        $this->setNom($nom);
        $this->setDescription($description);
        $this->setBlogueurId($blogueurId);
        $this->setDateCreation($dateCreation);
        $this->articles = array();
        $this->setBlogueur(null);
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

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $nom = trim($nom);
        if (empty($nom) || mb_strlen($nom, 'UTF-8') > 255)
            throw new InvalidArgumentException("Le nom '$nom' du blogue doit être entre 1 et 255 caractères.");
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $description = trim($description);
        if (empty($description) || mb_strlen($description, 'UTF-8') > 65535)
            throw new InvalidArgumentException("La description '$description' doit être entre 1 et 65535 caractères.");
        $this->description = $description;
        return $this;
    }

    public function getDateCreation(): ?DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getBlogueurId(): int
    {
        return $this->blogueurId;
    }

    public function setBlogueurId(int $blogueurId): self
    {
        $this->blogueurId = $blogueurId;
        return $this;
    }

    public function getBlogueur(): ?Utilisateur
    {
        return $this->blogueur;
    }

    public function setBlogueur(?Utilisateur $blogueur): self
    {
        $this->blogueur = $blogueur;
        return $this;
    }

    public function getArticles(): array
    {
        return $this->articles;
    }

    public function setArticles(array $articles): self
    {
        $this->articles = $articles;
        return $this;
    }

    public function ajouterArticle(Article $article)
    {
        $this->articles[] = $article;
    }
}
