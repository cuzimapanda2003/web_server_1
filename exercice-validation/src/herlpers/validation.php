<?php

function validerDate($date, $format = 'Y-m-d'): bool
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

function validerNombre($nb): bool
{
    return is_numeric($nb);
}

function validerOperateur($op): bool
{
    return ($op == '+' || $op == '-' || $op == '*' || $op == '/');
}

function validerDivisionZero($nb , $op): bool{
return($nb == 0 && $op == "/");
}
