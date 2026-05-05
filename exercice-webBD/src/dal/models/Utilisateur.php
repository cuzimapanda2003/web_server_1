<?php

class Utilisateur
{
    private int $id;
    private string $nomUtilisateur;
    private string $prenom;
    private string $nom;
    private string $courriel;
    private int $roleId;
    private ?Role $role;
    private ?string $cheminAvatar;
    private string $hash;


    public function __construct(string $nomUtilisateur, string $nom, string $prenom, string $courriel, int $roleId, string $hash, ?string $cheminAvatar = null, int $id = 0)
    {
        $this->setId($id);
        $this->setNomUtilisateur($nomUtilisateur);
        $this->setNom($nom);
        $this->setPrenom($prenom);
        $this->setCourriel($courriel);
        $this->setRoleId($roleId);
        $this->setCheminAvatar($cheminAvatar);
        $this->setHash($hash);
        $this->role = null;
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

    public function getNomUtilisateur(): string
    {
        return $this->nomUtilisateur;
    }

    public function setNomUtilisateur(string $nomUtilisateur): self
    {
        $nomUtilisateur = trim($nomUtilisateur);
        if (empty($nomUtilisateur) || mb_strlen($nomUtilisateur, 'UTF-8') > 50)
            throw new InvalidArgumentException("Le nom d'utilisateur '$nomUtilisateur' doit être entre 1 ET 50 caractères.");
        $this->nomUtilisateur = $nomUtilisateur;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $prenom = trim($prenom);
        if (empty($prenom) || mb_strlen($prenom, 'UTF-8') > 50)
            throw new InvalidArgumentException("Le prenom '$prenom' doit être entre 1 ET 50 caractères.");
        $this->prenom = $prenom;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $nom = trim($nom);
        if (empty($nom) || mb_strlen($nom, 'UTF-8') > 50)
            throw new InvalidArgumentException("Le nom '$nom' doit être entre 1 ET 50 caractères.");
        $this->nom = $nom;
        return $this;
    }

    public function getCourriel(): string
    {
        return $this->courriel;
    }

    public function setCourriel(string $courriel): self
    {
        $courriel = trim($courriel);
        if (mb_strlen($courriel, 'UTF-8') > 255 || !filter_var($courriel, FILTER_VALIDATE_EMAIL))
            throw new InvalidArgumentException("Le courriel '$courriel' n'est pas de format valide.");
        $this->courriel = $courriel;
        return $this;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): self
    {
        $this->roleId = $roleId;
        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {
        $this->role = $role;
        return $this;
    }

    public function getCheminAvatar(): ?string
    {
        return $this->cheminAvatar;
    }

    public function setCheminAvatar(?string $cheminAvatar): self
    {
        $this->cheminAvatar = $cheminAvatar;
        return $this;
    }

    public function getHash(): string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;
        return $this;
    }
}
