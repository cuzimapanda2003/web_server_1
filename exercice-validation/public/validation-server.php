

<?php
require_once '../src/herlpers/validation.php';
require_once '../src/herlpers/echappement.php';
$erreurs = array();
$infos = array();
if (!empty($_POST))
{
    $champ = $_POST['champ'] ?? '';
    if (validerDate($champ))
    {
        $infos[] = "La date $champ est d'un format date valide.";
        $champ = '';
    }
    else
    {
        $erreurs[] = "La date $champ n'est pas d'un format date valide.";
    }
}
?>

<!doctype html>
<html>
<style><?php require_once 'assets/css/style.css' ?></style>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Validation côté serveur</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

    <section id="contenu">
        <?php require_once '../includes/feedback.php'; ?>

        <div>
            <form action="validation-server.php" method="post">
                <label>
                    Champ : <input type="text" name="champ" value="<?= htmlspecialchars($champ ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </label>
                <input type="submit" name="bouton-envoi" value="Envoyer">
            </form>
        </div>
    </section>

    <?php require_once '../includes/pied.php'; ?>
</body>

</html>