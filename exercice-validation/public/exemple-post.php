 <?php
        require_once '../src/herlpers/validation.php';
        require_once '../src/herlpers/echappement.php';

        $erreurs = [];

        if (!empty($_POST)){
            $Prenom = $_POST['prenom'] ?? '';
            $Nom = $_POST['nom'] ?? '';
            $Grandeur = $_POST['grandeur'] ?? '';
            $date = $_POST['date-naissance'] ?? '';
            $sex = $_POST['sexe'] ?? '';
            $situation = $_POST['situation'] ?? '';
            $pres = $_POST['presentation'] ?? '';
            $rencontres = $_POST['rencontres'] ?? [];

            if (mb_strlen($Prenom, 'UTF-8') < 3 || mb_strlen($Prenom, 'UTF-8') > 20) {
                $erreurs[] = "Le Prenom doit avoir entre 3 et 20 caractere";
            }
            if (mb_strlen($Nom, 'UTF-8') < 3 || mb_strlen($Nom, 'UTF-8') > 20) {
                $erreurs[] = "Le nom doit avoir entre 3 et 20 caractere";
            }
            if (($Grandeur < 50 || $Grandeur > 250)) {
                $erreurs[] = "La grandeur doit avoir entre 50 et 250";
            }
            if (!validerDate($date)) {
                $erreurs[] = "La date n'est pas bonne";
            }
            if (!in_array($sex, ['1', '2'], true)) {
                $erreurs[] = "Veuillez sélectionner votre sexe";
            }
            $rencontres_valides = ['1', '2'];

            if (empty($rencontres)) {
                $erreurs[] = "Veuillez sélectionner au moins un type de rencontre";
            } else {
                foreach ($rencontres as $r) {
                    if (!in_array($r, $rencontres_valides, true)) {
                        $erreurs[] = "Type de rencontre invalide";
                        break;
                    }
                }
            }
            if (!in_array($situation, ['1', '2', '3', '4', '5'], true)) {
                $erreurs[] = "Situation invalide";
            }
            if (mb_strlen($pres, 'UTF-8') <= 20) {
                $erreurs[] = "La présentation doit contenir plus de 20 caractères";
            }
            if (empty($erreurs)) {
                $situationsTexte = [
                    '1' => 'Célibataire',
                    '2' => 'En couple',
                    '3' => 'Je ne sais pas',
                    '4' => "C'est compliqué",
                    '5' => 'Toutes ces réponses',
                    '6' => 'Réponse invalide'
                ];

                $infos[] = "$Prenom $Nom, vous vous êtes inscrit avec succès!";
                $infos[] = "Votre grandeur est de $Grandeur cm et vous ête né(e) le $date";
                $infos[] = "Vous êtes un(e) " . ($sex === '1' ? 'Homme' : 'Femme') . " et votre situation est :($situationsTexte[$situation])";
                $infos[] = "Type de rencotres choisi:";
                $choixRencontres = [];
                foreach ($rencontres as $r) {
                    if ($r === '1')
                        $choixRencontres[] = 'Homme';
                    if ($r === '2')
                        $choixRencontres[] = 'Femme';
                }
                $infos[] = "Type(s) de rencontre choisi(s) : " . implode(', ', $choixRencontres);
                $infos[] = "Votre présentation est: $pres";
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

        <form name="formulaire" action="exemple-post.php" method="post" class="form">



            <div>
                <label>Prénom :
                    <input required minlength="3" maxlength="20" type="text" name="prenom"
                        value="<?= echapperHtml($Prenom ?? '') ?>">
                </label>
            </div>

            <div>
                <label>
                    Nom :
                    <input type="text" name="nom" value="<?= echapperHtml($Nom ?? '') ?>">
                </label>
            </div>

            <div>
                <label>Grandeur :
                    <input type="number" name="grandeur" min="0" value="<?= echapperHtml($Grandeur ?? '') ?>"> cm
                </label>
            </div>

            <div><label>
                    Date de naissance :
                    <input type="date" name="date-naissance" value="<?= echapperHtml($date ?? '') ?>">
                </label>
            </div>

            <label>
                <input type="radio" name="sexe" value="1" <?= isset($sex) && $sex === '1' ? 'checked' : '' ?>> Homme
            </label>
            <label>
                <input type="radio" name="sexe" value="2" <?= isset($sex) && $sex === '2' ? 'checked' : '' ?>> Femme
            </label>
            </div>

            <div>
                <label>
                    <input type="checkbox" name="rencontres[]" value="1" <?= isset($rencontres) && in_array('1', $rencontres) ? 'checked' : '' ?>> Voulez vous rencontrer un homme
                </label>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="rencontres[]" value="2" <?= isset($rencontres) && in_array('2', $rencontres) ? 'checked' : '' ?>> Voulez vous rencontrer une Femme
                </label>
            </div>
            <div>
                <div>
                    <label>Situation :
                        <select name="situation">
                            <option value="1" <?= (isset($situation) && $situation === '1') ? 'selected' : '' ?>>
                                Célibataire</option>
                            <option value="2" <?= (isset($situation) && $situation === '2') ? 'selected' : '' ?>>En couple
                            </option>
                            <option value="3" <?= (isset($situation) && $situation === '3') ? 'selected' : '' ?>>Je ne sais
                                pas</option>
                            <option value="4" <?= (isset($situation) && $situation === '4') ? 'selected' : '' ?>>C'est
                                compliqué</option>
                            <option value="5" <?= (isset($situation) && $situation === '5') ? 'selected' : '' ?>>Toutes ces
                                réponses</option>
                            <option value="6" <?= (isset($situation) && $situation === '6') ? 'selected' : '' ?>>Réponse
                                invalide</option>
                        </select>
                    </label>
                </div>
            </div>
            <div>
                <textarea name="presentation" cols="30"
                    rows="4"><?= echapperHtml($pres ?? 'Présentez vous...') ?></textarea>
            </div>
            <input type="hidden" name="id" value="1">
            <div><input type="submit" name="bouton-envoyer" value="Envoyer"></div>



        </form>








    </section>

    <?php require_once '../includes/pied.php' ?>


</body>

</html>