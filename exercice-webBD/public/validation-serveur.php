<?php
$erreurs = array();
if (!empty($_POST))
{
    // Pour démontrer comment refournir la données du champ du formulaire en cas d'erreur
    $champ = $_POST['champ'] ?? '';

    // Pour démontrer comment fournir un message d'erreur à afficher (même principe pour $infos)
    $erreurs[] = "Un message d'erreur";
    // $infos[] = "Un message de succès";
}
?>

<!doctype html>
<html>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Validation côté serveur</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

    <section id="contenu">
        <?php require_once '../includes/retroaction.php'; ?>

        <div>
            <form action="validation-serveur.php" method="post">
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