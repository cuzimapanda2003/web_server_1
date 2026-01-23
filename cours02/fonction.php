<?php
// En mode strict, les types sont validés (paramètres et valeurs de retour).
// Sinon le comportement ressemble beaucoup à celui de javascript,
// c'est-à-dire que les types sont convertis implicitement (ex: "1.0" -> 1.0)
declare(strict_types=1);

function obtenirChoix(): int
{
    $valide = false;
    do
    {
        afficherMenu();
        // Pour voir l'effet du strict mode, enlevez la conversion explicite (int)
        $choix = (int) readLine("Votre choix : ");
        $valide = estValide($choix);
    } while (!$valide);

    return $choix;
}

function afficherMenu()
{
    echo "1 - Choix 1\n";
    echo "2 - Choix 2\n";
    echo "3 - Choix 3\n";
    echo "4 - Quitter\n";
}

function estValide(int $choix): bool
{
    if ($choix == 1 || $choix == 2 || $choix == 3 || $choix == 4)
        return true;
    return false;
}

$choix = obtenirChoix();
echo "Votre choix est : $choix\n";

?>