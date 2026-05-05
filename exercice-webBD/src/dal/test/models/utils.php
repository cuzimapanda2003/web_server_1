<?php 

function creerChaineDeTest(int $lg) : string
{
    $chaine = "";
    for ($i = 0; $i < $lg; $i++) {
        $chaine .= chr(rand(33, 126));
    }
    return $chaine;
}