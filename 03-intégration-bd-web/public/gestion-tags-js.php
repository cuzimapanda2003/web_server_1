<?php
require_once '../src/bootstrap.php';

$tagDao = new TagDao($connexionBd);

$erreurs = array();
$infos = array();

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
        $type = get_class($ex);
        $erreurs[] = "({$type}) - {$ex->getMessage()}";
    }
}

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
        <h2>Gestion des tags (demande de modification en JavaScript)</h2>
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
                                <!-- On n'envoie plus le formulaire au serveur. Voir code javascript plus bas. -->
                                <form name="form-demande-modification-tag">
                                    <input type="hidden" name="id" value="<?= $tag->getId() ?>">
                                    <input type="hidden" name="nom-actuel" value="<?= echapperHtml($tag->getNom()) ?>">
                                    <input type="submit" name="bouton-demande-modification" value="Modifier">
                                </form>
                            </td>

                            <td>
                                <form action="gestion-tags-js.php" method="post">
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
            <form name="form-ajouter-modifier-tag" action="gestion-tags-js.php" method="post">
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

    <script>
        // Après que le DOM soit chargé
        document.addEventListener('DOMContentLoaded', function() {

            // Pour chaque formulaire de demande de modification
            var formulaireDemandeModification = document.getElementsByName('form-demande-modification-tag');
            for (var i = 0; i < formulaireDemandeModification.length; i++) {

                // On ajoute un écouteur d'événement pour intercepter la soumission du formulaire
                formulaireDemandeModification[i].addEventListener('submit', function(e) {

                    // On évite l'envoie au serveur
                    e.preventDefault();

                    // On s'assure de ne pas être déjà en mode modification
                    if (document.querySelector('input[name="bouton-modifier"]') == null) {

                        // On désactive tous les boutons de demande de modification
                        var boutonsDemandeModification = document.querySelectorAll('input[name="bouton-demande-modification"]');
                        boutonsDemandeModification.forEach(function(bouton) {
                            bouton.disabled = true;
                        });

                        // On récupère le formulaire de demande de modification
                        // afin de récupérer les champs cachés à l'intérieur qui
                        // nous servirons à remplir les champs du formulaire de modification
                        const formDemandeModification = e.target;
                        const idTag = formDemandeModification.querySelector('input[name="id"]').value;
                        const nomActuel = formDemandeModification.querySelector('input[name="nom-actuel"]').value;

                        // On récupère le formulaire de d'ajout/modification
                        const formModification = document.getElementsByName('form-ajouter-modifier-tag')[0];

                        // On supprime le bouton d'ajout
                        formModification.querySelector('input[name="bouton-ajouter"]').remove();

                        // On ajoute un champ caché pour l'id du tag
                        const inputId = document.createElement('input');
                        inputId.type = 'hidden';
                        inputId.name = 'id';
                        inputId.value = idTag;
                        formModification.appendChild(inputId);

                        // On modifie le champ du nom du tag avec la valeur actuel
                        formModification.querySelector('input[name="nom-tag"]').value = nomActuel;

                        // On ajoute le bouton de modification
                        const inputModifier = document.createElement('input');
                        inputModifier.type = 'submit';
                        inputModifier.name = 'bouton-modifier';
                        inputModifier.value = 'Modifier';
                        formModification.appendChild(inputModifier);

                        // On ajoute le bouton d'annulation
                        const inputAnnuler = document.createElement('input');
                        inputAnnuler.type = 'submit';
                        inputAnnuler.name = 'bouton-annuler';
                        inputAnnuler.value = 'Annuler';
                        formModification.appendChild(inputAnnuler);
                    }
                });
            }
        });
    </script>
</body>

</html>