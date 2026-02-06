<?php
require_once 'De.php';
require_once 'DeTruque.php';
require_once 'DeSemiTruque.php';
require_once 'Joueur.php';

$DE = new De();
$DE_TRUC = new DeTruque(3);
$DE_SEMI = new DeSemiTruque(10, 5);

$player = new Joueur("marc", $DE, $DE_TRUC, $DE_SEMI);

for ($i = 1; $i < 6; $i++) {
    $player->brasser();
    $value = $player->getValeurDe();
    print_r("------------ BRASSAGE " . $i . " -------------- \n");
    print_r("Dé normal : " . $value[0] . "\n");
    print_r("Dé truqué : " . $value[1] . "\n");
    print_r("Dé semi-truqué : " . $value[2] . "\n");
    print_r("la somme des dé pour ce brassage : " . $player->somme() . "\n");
}
