<?php
require_once 'De.php';

class DeTruque extends De
{
    public function __construct(int $valeurTruquee)
    {
        // On peut appeler le constructeur parent
        parent::__construct(1);

        // On peut faire référence aux variables du parent
        $this->valeur = $valeurTruquee;
    }

    public function brasser(): int
    {
        // On écrase le comportement du parent en s'assurant de ne pas "rebrasser"
        return $this->valeur;
    }

    public function __toString(): string
    {
        return "Le dé truqué à la valeur de " . $this->valeur;
    }
}