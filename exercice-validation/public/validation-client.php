<!DOCTYPE html>
<style><?php require_once 'assets/css/style.css' ?></style>
<head>
<?php require_once '../includes/head.php'?>
<title>Mon premier site web en php</title>
</head>
<body>

    <?php require_once '../includes/head.php' ?>

    <section id="contenu">
       
<div>
    <?php if (!empty($_GET)) : ?>
        <p>Votre nom est : <?= $_GET['nom'] ?? '' ?></p>
        <p>Votre âge est : <?= $_GET['age'] ?? '' ?></p>
        <br>
        <hr><br>
    <?php endif; ?>
</div>

<div>
    
    <form class="form" action="validation-client.php" method="get">
        <p >Exemple de validation avec les attributs de validation html :</p>
        <div><label>Nom : <input type="text" name="nom" required></label></div>
        <div><label>Age : <input type="number" name="age" min="18" required></label></div>
        <input type="submit" name="bouton-envoi" value="Envoyer">
    </form>
</div>

<div>
   
    <form class="form" id="form-validation-js" action="validation-client.php" method="get">
         <p>Exemple de validation avec javascript :</p>
        <div>
            <label>Nom : <input type="text" name="nom"></label>
            <span id="erreur-nom" class="erreur"></span>
        </div>
        <div>
            <label>Age : <input type="number" name="age"></label>
            <span id="erreur-age" class="erreur"></span>
        </div>
        <input type="submit" name="bouton-envoi" value="Envoyer">
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const formulaire = document.querySelector("#form-validation-js");
            formulaire.addEventListener("submit", validerFormulaireAvantEnvoi);
        });

        function validerFormulaireAvantEnvoi(event) {
            const nom = document.querySelector("#form-validation-js input[name=nom]");
            const age = document.querySelector("#form-validation-js input[name=age]");
            const erreurNom = document.querySelector("#erreur-nom");
            const erreurAge = document.querySelector("#erreur-age");
            let erreur = false;

            if (nom.value.length < 2) {
                erreurNom.textContent = "Le nom doit contenir au moins 2 caractères.";
                erreur = true;
            } else {
                erreurNom.textContent = "";
            }

            if (age.value < 18) {
                erreurAge.textContent = "L'âge doit être supérieur ou égal à 18.";
                erreur = true;
            } else {
                erreurAge.textContent = "";
            }

            if (erreur) {
                event.preventDefault();
            }
        }
    </script>
</div>




    </section>

    <?php require_once '../includes/pied.php' ?>


</body>
</html>