<?php

/**
 * Classe pour gérer la connexion à une base de données via PDO.
 * Elle nous permet d'obtenir une connexion PDO réutilisable entre
 * les divers DAO.
 */
class ConnexionBd
{
    private ?PDO $connexion;

    private string $nomBD;
    private string $nomUtilisateur;
    private string $motDePasse;
    private string $adresseHote;
    private int $port;
    private string $encodage;
    private string $moteur;

    public function __construct(
        string $nomBD,
        string $nomUtilisateur,
        string $motDePasse,
        string $adresseHote = 'localhost',
        int $port = 3306,
        string $encodage = 'utf8mb4',
        string $moteur = 'mysql'
    )
    {
        $this->connexion = null;

        $this->nomBD = $nomBD;
        $this->nomUtilisateur = $nomUtilisateur;
        $this->motDePasse = $motDePasse;
        $this->adresseHote = $adresseHote;
        $this->port = $port;
        $this->encodage = $encodage;
        $this->moteur = $moteur;
    }

    /**
     * Retourne la connexion à la BD (PDO).
     * 
     * @return PDO La connexion à la BD.
     * @throws PDOException S'il y a une erreur de connexion.
     */
    public function getConnexionPDO(): PDO
    {
        if ($this->connexion === null)
        {
            $this->connexion = new PDO(
                $this->creerChaineConnexion(),
                $this->nomUtilisateur,
                $this->motDePasse,
                array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_FOUND_ROWS => true
                )
            );
        }

        return $this->connexion;
    }

    private function creerChaineConnexion(): string
    {
        return "{$this->moteur}:dbname={$this->nomBD};host={$this->adresseHote};port={$this->port};charset={$this->encodage}";
    }

    /**
     * Destructeur. Libère la connexion à la BD.
     */
    function __destruct()
    {
        $this->connexion = null;
    }
}
