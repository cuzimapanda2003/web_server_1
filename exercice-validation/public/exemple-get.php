<?php
require_once '../src/herlpers/validation.php';
require_once '../src/herlpers/echappement.php';

$erreurs = [];

if (!empty($_GET)) {

    $nb1 = $_GET['nombre1'] ?? '';
    $nb2 = $_GET['nombre2'] ?? '';
    $op = $_GET['operateur'] ?? '';

    if (!validerNombre($nb1) || !validerNombre($nb2)) {
        $erreurs[] = "Les opérandes doivent être des nombres";
    }
    if(!validerOperateur($op)){
        $erreurs[] = "Opérateur non valide";
    }
    if(validerDivisionZero($nb2, $op)){
        $erreurs[] = "Division par zero impossible";
    }
}
?>



<!DOCTYPE html>
<style>
    <?php require_once 'assets/css/style.css' ?>
</style>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Mon premier site web en php</title>
</head>

<body>

    <?php require_once '../includes/head.php' ?>

    <section id="contenu">
        <?php require_once '../includes/feedback.php'; ?>
        <form class="form" id="form-validation-js" action="exemple-get.php" method="get">
            <div>

                <?php
                if (!empty($_GET)):

                    $n1 = (float) $_GET['nombre1'];
                    $n2 = (float) $_GET['nombre2'];
                    $op = $_GET['operateur'];
                    $resultat = "";

                    switch ($op) {
                        case "+":
                            $resultat = $n1 + $n2;
                            break;
                        case "-":
                            $resultat = $n1 - $n2;
                            break;
                        case "*":
                            $resultat = $n1 * $n2;
                            break;
                        case "/":
                            if ($n2 != 0) {
                                $resultat = $n1 / $n2;
                            } else {
                                $resultat = "Division par zéro impossible";
                            }
                            break;
                    }
                    ?>
                    <p>
                        <?= $n1 ?>
                        <?= $op ?>
                        <?= $n2 ?>
                        =
                        <?= $resultat ?>
                    </p>

                <?php endif; ?>


                <label>
                    <input type="text" name="nombre1">
                    <select name="operateur">
                        <option value="+" selected>+</option>
                        <option value="-">-</option>
                        <option value="*">*</option>
                        <option value="/">/</option>
                    </select>
                    <input type="text" name="nombre2">
                    <input type="submit" name="bouton-envoyer" value="=">
                    <span id="erreur-nombre" class="erreur"></span>
                    <span id="erreur-operateur" class="erreur"></span>
                </label>
            </div>
        </form>

        <div><a
                href="https://www.google.com/search?q=php&sca_esv=109ab09de071e349&hl=fr&sxsrf=ANbL-n5G9SmHK3BuzLmpeP31bq3IQUJAUw%3A1770993802495&source=hp&ei=ijiPacizHMi_0PEPpbWC0A8&iflsig=AFdpzrgAAAAAaY9GmvMPYjToNURJT9DyLHrxPXLBwmdm&ved=0ahUKEwjIoPuD2taSAxXIHzQIHaWaAPoQ4dUDCDI&uact=5&oq=php&gs_lp=Egdnd3Mtd2l6IgNwaHAyBRAAGIAEMgUQABiABDIFEAAYgAQyCxAuGIAEGMcBGK8BMgUQABiABDIFEAAYgAQyBRAAGIAEMgUQABiABDIFEAAYgAQyBRAAGIAESMgCUABY0AFwAHgAkAEAmAFSoAHyAaoBATO4AQPIAQD4AQGYAgOgAvsBwgIEECMYJ8ICChAjGIAEGCcYigXCAg4QABiABBixAxiDARiKBcICCxAAGIAEGLEDGIMBwgIOEC4YgAQYsQMY0QMYxwHCAggQABiABBixA8ICDhAuGIAEGLEDGIMBGIoFwgIIEC4YgAQYsQOYAwCSBwEzoAe4IbIHATO4B_sBwgcFMC4yLjHIBwaACAA&sclient=gws-wiz">
                recherche php sur google</a></div>

        <div>
            <a
                href="http://192.168.56.103/exercice-structure/public/exemple-get.php?nombre1=20&Op%C3%A9rateur=%2F&nombre2=5&bouton-envoyer=%3D">
                calcul 20/5
            </a>
        </div>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const formulaire = document.querySelector("#form-validation-js");
                formulaire.addEventListener("submit", validerFormulaireAvantEnvoi);
            });

            function validerFormulaireAvantEnvoi(event) {
                const nombre1 = document.querySelector("#form-validation-js input[name=nombre1]");
                const nombre2 = document.querySelector("#form-validation-js input[name=nombre2]");
                const erreurNombre = document.querySelector("#erreur-nombre");

                let erreur = false;

                const n1 = Number(nombre1.value);
                const n2 = Number(nombre2.value);

                if (isNaN(n1) || isNaN(n2)) {
                    erreurNombre.textContent = "Les opérandes doivent être des nombres";
                    erreur = true;
                } else {
                    erreurNombre.textContent = "";
                }
                if (erreur) {
                    event.preventDefault();
                }
            }
        </script>


    </section>

    <?php require_once '../includes/pied.php' ?>


</body>

</html>