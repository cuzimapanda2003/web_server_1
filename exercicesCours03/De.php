<?php

/**
 * Classe représentant un Dé à jouer
 */
class De
{
    // Constante accessible seulement dans la classe et enfants
    protected const NB_FACES_DEFAUT = 6;

    // Variables d'instance (membres, propriétés...)
    protected int $valeur;
    protected int $nbFaces;

    /**
     * Constructeur d'un dé.
     * @param string $nbFaces Le nombre de faces du dé. Doit être > 0.
     */
    public function __construct(int $nbFaces = self::NB_FACES_DEFAUT)
    {
        // Notez que pour accéder à une variable d'instance, 
        // il faut utiliser $this->nomDeLaVariableSansLeSigneDe$
        $this->valeur = 1;

        // Appel d'une méthode
        $this->setNbFaces($nbFaces);
    }

    /**
     * Méthode permettant de brasser le dé.
     * 
     * @return int La nouvelle valeur du dé.
     */
    public function brasser(): int
    {
        $this->valeur = rand(1, $this->nbFaces);
        return $this->valeur;
    }


    /**
     * @return int La valeur actuelle du dé.
     */
    public function getValeur(): int
    {
        return $this->valeur;
    }

    /**
     * @return int Le nombre de face du Dé.
     */
    public function getNbFaces(): int
    {
        return $this->nbFaces;
    }

    /**
     * Gère l'affectation du nombre de faces du dé.
     * 
     * @param int nbFaces Le nombre de faces. Doit être > 0.
     * 
     * @throws Exception Lance une exception lorsque le nombre de faces est non valides
     */
    private function setNbFaces(int $nbFaces)
    {
        if ($nbFaces <= 0)
            throw new Exception("Le nombre de faces $nbFaces est non valide!");

        $this->nbFaces = $nbFaces;
    }

    /**
     * Il est possible de définir un comportement lorsque php doit représenter notre objet sous
     * forme de chaîne de caractères. Ceci est possible en définissant la méthode __toString(). 
     * Elle doit impérativement retourner une chaîne.
     * 
     * @return string Représentation textuelle du dé.
     */
    public function __toString(): string
    {
        return "Le dé à la valeur de " . $this->valeur;
    }
}
