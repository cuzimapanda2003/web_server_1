<!doctype html>
<html>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Validation côté client</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

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
            <p>Exemple de validation avec les attributs de validation html :</p>
            <form action="validation-client.php" method="get">
                <div><label>Nom : <input type="text" name="nom" required></label></div>
                <div><label>Age : <input type="number" name="age" min="18" required></label></div>
                <input type="submit" name="bouton-envoi" value="Envoyer">
            </form>
        </div>

        <br>
        <hr>
        <br>

        <div>
            <p>Exemple de validation avec javascript :</p>
            <form id="form-validation-js" action="validation-client.php" method="get">
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
        </div>

        <br>
        <hr>
        <br>

        <div>
            <p>
                Notez qu'il y a plusieurs variations d'utilisation de ces possibilités.
                Je vous invite à lire <a href="https://developer.mozilla.org/fr/docs/Learn/Forms/Form_validation" target="_blank">cet article</a>.
            </p>
        </div>
    </section>

    <?php require_once '../includes/pied.php'; ?>

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
</body>

</html>