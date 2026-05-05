<?php

class RoleDao extends BaseDao
{
    function __construct(ConnexionBd $connexionBd)
    {
        parent::__construct($connexionBd);
    }

    public function select(int $id): ?Role
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT * FROM role WHERE id = :id");
        $requete->bindValue(":id", $id, PDO::PARAM_INT);
        $requete->execute();

        $role = null;
        if ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $role = new Role($enregistrement['nom'], $enregistrement['id']);
        }

        return $role;
    }
}
