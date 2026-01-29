<?php

declare(strict_types=1);
require_once 'De.php';
require_once 'DeTruque.php';

try
{
    // Utilisation d'un tableau pour faire un gobelet de Dé/DéTruqué
    $gobelet = array(new De(10), new De(), new DeTruque(7), new DeTruque(8));

    foreach ($gobelet as $de)
    {
        $de->brasser();
        echo "$de\n"; // Le __toString() sera appelé
    }
}
catch (Exception $ex)
{
    echo $ex->getMessage() . "\n";
}