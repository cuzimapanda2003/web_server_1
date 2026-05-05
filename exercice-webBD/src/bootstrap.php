<?php
require_once __DIR__ . '/autoloader.php';
require_once __DIR__ . '/helpers/echappement.php';
require_once __DIR__ . '/helpers/validation.php';


const NOM_BD = "blogue";
const NOM_UTILISATEUR_BD = "etd";
define("MDP_BD", "shawi"); // Autre façon de déclarer un constante

$connexionBd = new ConnexionBd(NOM_BD, NOM_UTILISATEUR_BD, MDP_BD);