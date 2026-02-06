<?php
require_once 'De.php';


class DeSemiTruque extends De
{

    private int $valeurTruquee = 3;
    private bool $aleatoire;

    public function __construct(int $nbFace, int $valeurTruquee)
    {
        parent::__construct($nbFace);
        $this->aleatoire = true;
        $this->setValeurTruquee($valeurTruquee);

    }

    public function brasser(): int
    {
        if ($this->aleatoire == false) {
            $this->aleatoire = true;
            return $this->valeurTruquee;
        } else {
            $this->valeur = rand(1, $this->nbFaces);
            $this->aleatoire = false;
            return $this->valeur;
        }
    }

    private function setValeurTruquee(int $valeurTruquee)
    {
        if ($this->nbFaces < $valeurTruquee || $this->nbFaces <= 0)
            throw new Exception("Le nombre de faces $valeurTruquee est non valide!");
        $this->valeurTruquee = $valeurTruquee;
    }

    public function __toString(): string
    {
        return "la valeur est " . $this->valeur . "et la valeur truquer est " . $this->valeurTruquee;
    }
}
