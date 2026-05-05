<?php
require_once '../src/bootstrap.php';

$tagDao = new TagDao($connexionBd);

$erreurs = array();
$infos = array();

// Un formulaire quelconque est existant
if (!empty($_POST))
{
    try
    {
        // Nous sommes dans le cas d'un ajout de tag
        if (isset($_POST['bouton-ajouter']))
        {
            $nomTag = $_POST['nom-tag'] ?? '';

            $tag = new Tag($nomTag);
            $tagDao->insert($tag);
            $infos[] = "Tag '$nomTag' ajouté avec succès!";
            $nomTag = "";
        }
        // Nous sommes dans le cas de suppression d'un tag
        else if (isset($_POST['bouton-supprimer']))
        {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if (is_int($id))
            {
                $tagDao->delete($id);
                $infos[] = "Tag supprimé avec succès!";
            }
        }
        // Nous sommes dans le cas d'une demande de modification d'un tag
        else if (isset($_POST['bouton-demande-modification']))
        {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            if (is_int($id))
            {
                $tagAModifier = $tagDao->select($id);
                if ($tagAModifier != null) $nomTag = $tagAModifier->getNom();
            }
        }
        // Nous sommes dans le cas de la modification d'un tag
        else if (isset($_POST['bouton-modifier']))
        {
            $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
            $nomTag = $_POST['nom-tag'] ?? '';
            if (is_int($id))
            {
                $tagAModifier = $tagDao->select($id);
                if ($tagAModifier != null)
                {
                    $tagAModifier->setNom($nomTag);
                    $tagDao->update($tagAModifier);
                    $tagAModifier = null;
                    $nomTag = "";
                    $infos[] = "Tag modifié avec succès!";
                }
            }
        }
    }
    catch (InvalidArgumentException $ex)
    {
        // Erreur de validation/modèle
        $erreurs[] = $ex->getMessage();
    }
    catch (Throwable  $ex)
    {
        // Fort probablement une exception PDO (ou autre)
        // On n'affichige pas le contenu de l'exception habituellement
        // Elle peut contenir des informations sensibles.
        // Mettre un message générique à la place ou personnaliser le message.
        // Toutefois, pour les fins de cet exercice, on affiche le message.
        $type = get_class($ex);
        $erreurs[] = "({$type}) - {$ex->getMessage()}";
    }
}

// On fait la sélection de tous les tags à la fin pour être en mesure de
// réfléter les changements à la suite d'un ajout/modification/suppression.
$tags = $tagDao->selectAll();
?>

<!doctype html>
<html>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Gestion des tags</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

    <section id="contenu">
        <?php require_once '../includes/retroaction.php'; ?>
        <h2>Gestion des tags</h2>
        <div class="mt-3">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Tag</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tags as $tag) : ?>
                        <tr>
                            <td><?= echapperHtml($tag->getNom()) ?></td>

                            <td>
                                <form action="gestion-tags.php" method="post">
                                    <input type="hidden" name="id" value="<?= $tag->getId() ?>">
                                    <input type="submit" name="bouton-demande-modification" value="Modifier">
                                </form>
                            </td>

                            <td>
                                <form action="gestion-tags.php" method="post">
                                    <input type="hidden" name="id" value="<?= $tag->getId() ?>">
                                    <input type="submit" name="bouton-supprimer" value="Supprimer">
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-5">
            <form name="form-ajouter-modifier-tag" action="gestion-tags.php" method="post">
                <label>Tag : <input type="text" name="nom-tag" value="<?= echapperHtml($nomTag ?? '') ?>"></label>

                <?php if (isset($tagAModifier)) : ?>
                    <input type="hidden" name="id" value="<?= $tagAModifier->getId() ?>">
                    <input type="submit" name="bouton-modifier" value="Modifier">
                    <input type="submit" name="bouton-annuler" value="Annuler">
                <?php else : ?>
                    <input type="submit" name="bouton-ajouter" value="Ajouter">
                <?php endif; ?>
            </form>
        </div>
    </section>

    <?php require_once '../includes/pied.php'; ?>
</body>

</html>