<?php

/**
 * Classe abstraite parent pour tous les DAO liés à une BD.
 * Un DAO se spécialise dans les opérations sur une table
 * et accessoirement sur les tables de jointures de cette
 * dernière.
 */
abstract class BaseDao
{
    protected ConnexionBd $connexionBd;

    public function __construct(ConnexionBd $connexionBd)
    {
        $this->connexionBd = $connexionBd;
    }

    /**
     * Méthode pour rapidement accéder à la connexion PDO.
     * 
     * @return PDO La connexion à la BD (PDO).
     * @throws PDOException S'il y a une erreur de connexion.
     */
    protected function getConnexion(): PDO
    {
        return $this->connexionBd->getConnexionPDO();
    }
}
