<?php
require_once '../src/helpers/echappement.php';
require_once '../src/helpers/validation.php';

// Tableaux de référence pour bouton radio, cases à cocher et liste déroulante
// NOTE: Généralement, ces informations viennent d'une base de données...
$ref_sexes = array(1 => 'Homme', 2 => 'Femme');

$ref_rencontres = array(
    1 => 'Je veux rencontrer un homme',
    2 => 'Je veux rencontrer une femme',
);

$ref_situations = array(
    1 => 'Célibataire',
    2 => 'En couple',
    3 => 'Je ne sais pas',
    4 => 'C\'est compliqué',
    5 => 'Toutes ces réponses'
);

// Tableaux pour stocker les messages d'erreurs et d'informations
$erreurs = array();
$infos = array();

// Valeurs par défaut des champs du formulaire
$prenom = '';
$nom = '';
$grandeur = '';
$dateDeNaissance = '';
$sexe = '1';
$rencontres = array();
$id = '1';
$situation = '1';
$presentation = '';

// Traitement du formulaire lors de la soumission
if (!empty($_POST))
{
    $prenom = trim($_POST['prenom'] ?? '');
    if (mb_strlen($prenom, 'UTF-8') < 3 || mb_strlen($prenom, 'UTF-8') > 20)
    {
        $erreurs[] = "Le prénom doit être entre 3 et 20 caractères.";
    }

    $nom = trim($_POST['nom'] ?? '');
    if (mb_strlen($nom, 'UTF-8') < 3 || mb_strlen($nom, 'UTF-8') > 20)
    {
        $erreurs[] = "Le nom doit être entre 3 et 20 caractères.";
    }

    $grandeur = filter_input(INPUT_POST, 'grandeur', FILTER_VALIDATE_INT);
    if (!is_int($grandeur) || $grandeur < 50 || $grandeur > 250)
    {
        $erreurs[] = "La grandeur doit être un nombre entier entre 50 et 250 cm.";
    }

    $dateDeNaissance = $_POST['date-naissance'] ?? '';
    if (!validerDate($dateDeNaissance))
    {
        $erreurs[] = "La date de naissance doit être de format AAAA-MM-JJ.";
    }

    $sexe = filter_input(INPUT_POST, 'sexe', FILTER_VALIDATE_INT);
    if (!is_int($sexe) || !array_key_exists($sexe, $ref_sexes))
    {
        $erreurs[] = "Le sexe fourni est non valide. Plutôt étrange...";
    }

    $rencontres = filter_input(INPUT_POST, 'rencontres', FILTER_VALIDATE_INT, FILTER_REQUIRE_ARRAY);
    if (!is_array($rencontres) || empty($rencontres))
    {
        $rencontres = array();
        $erreurs[] = "Vous devez choisir au moins un type de rencontre.";
    }
    else
    {
        foreach ($rencontres as $r)
        {
            if (!is_int($r) || !array_key_exists($r, $ref_rencontres))
            {
                $erreurs[] = "Type de rencontre non reconnu... essayez-vous de contourner notre super beau formulaire?";
                break;
            }
        }

        // Alternative de validation
        // Array diff retourne un tableau contenant $rencontres - les clés de $ref_rencontres.
        // Si le tableau retourné est vide, alors toutes les valeurs de $rencontres sont valides.
        // if (!empty(array_diff($rencontres, array_keys($ref_rencontres))))
        // {
        //     $erreurs[] = "Type de rencontre non reconnu... essayez-vous de contourner notre super beau formulaire?";
        // }
    }

    $situation = filter_input(INPUT_POST, 'situation', FILTER_VALIDATE_INT);
    if (!is_int($situation) || !array_key_exists($situation, $ref_situations))
    {
        $erreurs[] = "Votre situation est plutôt ambigüe!";
    }

    $presentation = trim($_POST['presentation'] ?? '');
    if (mb_strlen($presentation, 'UTF-8') < 20)
    {
        $erreurs[] = "Présentez-vous un peu plus... la paresse s'est emparée de vous!!!";
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!is_int($id) || $id <= 0)
    {
        $erreurs[] = "ID non valide.";
    }

    if (empty($erreurs))
    {
        // Message de succès
        $infos[] = "$prenom $nom, vous vous êtes inscrit avec succès!";
        $infos[] = "Votre grandeur est de $grandeur cm et vous êtes né(e) le $dateDeNaissance.";
        $infos[] = "Vous êtes un(e) " . $ref_sexes[$sexe] . " et votre situation est : " . $ref_situations[$situation] . ".";
        $infos[] = "Types de rencontres choisis :";
        foreach ($rencontres as $r)
        {
            $infos[] = "- " . $ref_rencontres[$r];;
        }
        $infos[] = "Votre présentation est : $presentation";

        // Réinitialisation des valeurs du formulaire
        $prenom = '';
        $nom = '';
        $grandeur = '';
        $dateDeNaissance = '';
        $sexe = '1';
        $rencontres = array();
        $id = '1';
        $situation = '1';
        $presentation = '';
    }
}
?>

<!doctype html>
<html>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Exemple POST</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

    <section id="contenu">
        <?php require_once '../includes/retroaction.php'; ?>

        <form name="inscription" action="exemple-post.php" method="post">
            <div><label>Prénom : <input type="text" name="prenom" value="<?= echapperHtml($prenom)?>" minlength="3" maxlength="20" required></label></div>

            <div><label>Nom : <input type="text" name="nom" value="<?= echapperHtml($nom)?>"></label></div>
            
            <div><label>Grandeur : <input type="number" name="grandeur" value="<?= echapperHtml($grandeur)?>"> cm</label></div>
            
            <div><label>Date de naissance : <input type="date" name="date-naissance" value="<?= echapperHtml($dateDeNaissance)?>"></label></div>
            
            <div>
                <?php foreach ($ref_sexes as $clef => $valeur): ?>
                    <label><input type="radio" name="sexe" value="<?= $clef ?>" <?= $clef == $sexe ? 'checked' : '' ?>><?= $valeur ?></label>
                <?php endforeach; ?>
            </div>
            
            <?php foreach ($ref_rencontres as $clef => $valeur): ?>
                <div><label><input type="checkbox" name="rencontres[]" value="<?= $clef ?>" <?= in_array($clef, $rencontres) ? 'checked' : '' ?>><?= $valeur ?></label></div>
            <?php endforeach; ?>
            
            <div>
                <label>
                    Situation :
                    <select name="situation">
                        <?php foreach ($ref_situations as $clef => $valeur): ?>
                            <option value="<?= $clef ?>" <?= $clef == $situation ? 'selected' : '' ?>><?= $valeur ?></option>
                        <?php endforeach; ?>
                    </select>
                </label>
            </div>
            
            <div><textarea name="presentation" cols="30" rows="4"><?= echapperHtml($presentation) ?></textarea></div>
            
            <input type="hidden" name="id" value="<?= echapperHtml($id) ?>">
            
            <div><input type="submit" name="bouton-envoyer" value="Envoyer"></div>
        </form>
    </section>

    <?php require_once '../includes/pied.php'; ?>
</body>

</html>