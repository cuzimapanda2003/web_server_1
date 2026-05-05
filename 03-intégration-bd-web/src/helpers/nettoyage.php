<?php

function garderXnombreCaracteres($texte, $nombreCaracteres)
{
    if (mb_strlen($texte, 'UTF-8') <= $nombreCaracteres)
    {
        return $texte;
    }

    return mb_substr($texte, 0, $nombreCaracteres, 'UTF-8') . '...';
}