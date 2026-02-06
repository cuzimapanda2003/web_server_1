<?php
require_once 'De.php';

class Joueur
{
    private string $nomComplet;
    private ?string $surnom = null;
    private array $goblet;
    private array $valeur;

    public function __construct(string $nomComplet, De $de1, De $de2, De $de3)
    {
        $this->nomComplet = $nomComplet;

        $this->goblet[0] = $de1;
        $this->goblet[1] = $de2;
        $this->goblet[2] = $de3;
    }

    public function brasser(): array
    {
        for ($i = 0; $i < 3; $i++) {
            $this->valeur[$i] =  $this->goblet[$i]->brasser();
        }
        return $this->valeur;
    }

    public function somme(): int
    {
        return array_sum($this->valeur);
    }

    public function getValeurDe(): array
    {
        return $this->valeur;
    }

    public function getNomComplet(): string
    {
        return $this->nomComplet;
    }

    public function getSurnom(): ?string
    {
        return $this->surnom;
    }

    public function setSurnom(?string $surnom): void
    {
        $this->surnom = $surnom;
    }
}
