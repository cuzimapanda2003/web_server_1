<?php
$erreurs = array();
$infos = array();
if (!empty($_GET))
{
    $operande1 = filter_input(INPUT_GET, 'operande1', FILTER_VALIDATE_FLOAT );
    $operateur = $_GET['operateur'] ?? '';
    $operande2 = filter_input(INPUT_GET, 'operande2', FILTER_VALIDATE_FLOAT );

    if (is_float($operande1) && is_float($operande2))
    {
        $reponse = '';
        switch ($operateur)
        {
            case '+':
                $reponse = $operande1 + $operande2;
                break;

            case '-':
                $reponse = $operande1 - $operande2;
                break;

            case '*':
                $reponse = $operande1 * $operande2;
                break;

            case '/':
                if ($operande2 != 0)
                {
                    $reponse = $operande1 / $operande2;
                }
                else
                {
                    $erreurs[] = "Division par 0 impossible!";
                }
                break;

            default:
                $erreurs[] = 'Opérateur inconnu!';
                break;
        }

        if ($reponse !== '')
        {
            $infos[] = "$operande1 $operateur $operande2 = $reponse";
        }
    }
    else
    {
        $erreurs[] = "Les opérandes doivent être numériques!";
    }
}
?>

<!doctype html>
<html>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Exemple GET</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

    <section id="contenu">
        <?php require_once '../includes/retroaction.php'; ?>

        <form id="form-calculatrice" name="calculatrice" action="exemple-get.php" method="get">
            <input type="text" size="4" maxlength="4" name="operande1">
            <select name="operateur">
                <option value="+" selected>+</option>
                <option value="-">-</option>
                <option value="*">*</option>
                <option value="/">/</option>
            </select>
            <input type="text" size="4" maxlength="4" name="operande2">
            <input type="submit" name="bouton-calculer" value="=">
            <span id="erreur-calculatrice" class="erreur"></span>
        </form>

        <div><a href="https://www.google.ca/search?q=php" target="_blank">Recherche pour php sur Google</a></div>
        <div><a href="exemple-get.php?operande1=20&operateur=%2F&operande2=5&bouton-calculer=%3D">Calcul de 20 / 5</a></div>
    </section>

    <?php require_once '../includes/pied.php'; ?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const formulaire = document.querySelector("#form-calculatrice");
            formulaire.addEventListener("submit", validerFormulaireAvantEnvoi);
        });

        function validerFormulaireAvantEnvoi(event) {
            const operande1 = document.querySelector("#form-calculatrice input[name=operande1]");
            const operande2 = document.querySelector("#form-calculatrice input[name=operande2]");

            const spanErreur = document.querySelector("#erreur-calculatrice");

            const op1 = operande1.value.trim();
            const op2 = operande2.value.trim();
            if (op1 === "" || isNaN(op1) || op2 === "" || isNaN(op2)) {
                spanErreur.innerHTML = "Les opérandes doivent être des nombres!";
                event.preventDefault();
                return;
            } else {
                spanErreur.innerHTML = "";
            }
        }
    </script>
</body>

</html>