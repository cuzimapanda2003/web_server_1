<?php
require_once "../src/bootstrap.php";

$blogueDao = new BlogueDao($connexionBd);
$tagDao = new TagDao($connexionBd);
$articleDao = new ArticleDao($connexionBd);

$erreurs = array();
$infos = array();
$tagsIds = array();
$publie = true;

$refTags = $tagDao->selectAll();

// Nous ne savons pas si le blogue-id vient en GET ou en POST (affichage ou action)
$blogueId = filter_input(INPUT_GET, 'blogue-id', FILTER_VALIDATE_INT);
if (!is_int($blogueId)) {
    $blogueId = filter_input(INPUT_POST, 'blogue-id', FILTER_VALIDATE_INT);
}

if (is_int($blogueId))
{
    // On récupère le blogue à afficher
    $blogue = $blogueDao->select($blogueId);

    if ($blogue != null)
    {
        // Gestion des actions sur les articles
        try
        {
            // Ajout d'un article
            if (isset($_POST['bouton-ajouter']))
            {
                $titre = $_POST['titre'] ?? '';
                $texte = $_POST['texte'] ?? '';
                $publie = (($_POST['publie'] ?? 'false') === 'true');
                $tagsIds = isset($_POST['tags']) ? $_POST['tags'] : array();

                $nvArticle = new Article($titre, $texte, $blogue->getBlogueurId(), $publie);
                $tagsArticle = $tagDao->selectParIds($tagsIds);
                $nvArticle->setTags($tagsArticle);

                $articleDao->insert($nvArticle);
                $titre = '';
                $texte = '';
                $publie = true;
                $tagsIds = array();
                $infos[] = 'L\'article a été ajouté avec succès.';
            }
            // Demande de modification d'un article
            else if (isset($_POST['bouton-demande-modification']))
            {
                $articleId = $_POST['article-id'] ?? 0;

                $articleAModifier = $articleDao->select($articleId);
                if ($articleAModifier != null)
                {
                    $titre = $articleAModifier->getTitre();
                    $texte = $articleAModifier->getTexte();
                    $publie = $articleAModifier->isPublie();
                    foreach ($articleAModifier->getTags() as $tag)
                    {
                        $tagsIds[] = $tag->getId();
                    }
                }
            }
            // Modification d'un article
            else if (isset($_POST['bouton-modifier']))
            {
                $articleId = $_POST['article-id'] ?? 0;
                $titre = $_POST['titre'] ?? '';
                $texte = $_POST['texte'] ?? '';
                $publie = (($_POST['publie'] ?? 'false') === 'true');
                $tagsIds = isset($_POST['tags']) ? $_POST['tags'] : array();

                $articleAModifier = $articleDao->select($articleId);
                if ($articleAModifier != null)
                {
                    $articleAModifier->setTitre($titre);
                    $articleAModifier->setTexte($texte);
                    $articleAModifier->setTags(array());
                    $articleAModifier->setPublie($publie);
                    $tagsArticle = $tagDao->selectParIds($tagsIds);
                    $articleAModifier->setTags($tagsArticle);

                    $articleDao->update($articleAModifier);
                    $articleAModifier = null;
                    $titre = '';
                    $texte = '';
                    $publie = true;
                    $tagsIds = array();
                    $infos[] = "L'article a été modifié avec succès.";
                }
            }
            // Annulation de la modification
            else if (isset($_POST['bouton-annuler']))
            {
                $infos[] = 'La modification a été annulée.';
            }
            // Suppression d'un article
            else if (isset($_POST['bouton-supprimer']))
            {
                $articleId = $_POST['article-id'] ?? 0;
                $articleDao->delete($articleId);
                $infos[] = 'L\'article a été supprimé avec succès.';
            }
        }
        catch (InvalidArgumentException $e)
        {
            $erreurs[] = $e->getMessage();
        }
        catch (Throwable $ex)
        {
            $erreurs[] = "Erreur système.";
        }
        finally
        {
            // On récupère les articles du blogueur
            $blogue->setArticles($articleDao->selectAllParUtilisateurId($blogue->getBlogueurId()));   
        }
    }
    else
    {
        $erreurs[] = 'Le blogue demandé n\'existe pas.';
    }
}
else
{
    $erreurs[] = 'Le blogue demandé n\'existe pas.';
}
?>

<!doctype html>
<html>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Blogue</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

    <section id="contenu">
        <div class="pb-4">
            <a class="btn btn-secondary" href="liste-blogues.php">
                Retour à la liste des blogues
            </a>
        </div>

        <?php if (isset($blogue)) : ?>
            <div class="card p-2 flex-row">
                <img class="card-img-left rounded" style="width: 20rem; height: 20rem;" src="<?= $blogue->getBlogueur()->getCheminAvatar() != null ? echapperHtml($blogue->getBlogueur()->getCheminAvatar()) : 'assets/img/image-profil-place-holder.png' ?>" />
                <div class="card-body">
                    <h4 class="card-title h4-sm">Bienvenue sur le blogue <?= echapperHtml($blogue->getNom()) ?></h4>
                    <p class="card-text small"><?= echapperHtml($blogue->getDescription()) ?></p>
                    <p class="card-text small"><i>Blogue de <?= echapperHtml($blogue->getBlogueur()->getPrenom()) ?> <?= echapperHtml($blogue->getBlogueur()->getNom()) ?></i></p>
                    <p class="card-text small"><i>Créé le <?= $blogue->getDateCreation()->format('Y-m-d H:i:s') ?></i></p>
                </div>
            </div>

            <br>
            <hr>
            <br>

            <div class="d-flex justify-content-around flex-wrap p-2">
                <?php foreach ($blogue->getArticles() as $article) : ?>
                    <div class="card" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title"><a href="article.php?article-id=<?= $article->getId() ?>"><?= echapperHtml($article->getTitre()) ?></a></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Créé le <?= $article->getDateCreation()->format('Y-m-d H:i:s') ?></h6>
                            <h6 class="card-subtitle mb-2 text-muted">Modifié le <?= $article->getDateModification()->format('Y-m-d H:i:s') ?></h6>
                            <h6 class="card-subtitle mb-2 text-muted">Publié : <?= $article->isPublie() ? 'Oui' : 'Non' ?></h6>
                            <p class="card-text"><?= echapperHtml(garderXnombreCaracteres($article->getTexte(), 30)) ?></p>
                            <form name="form-demande-modification-article" style="display:inline-block" action="blogue.php#retroaction" method="post">
                                <input type="hidden" name="article-id" value="<?= $article->getId() ?>">
                                <input type="hidden" name="blogue-id" value="<?= $blogue->getId() ?>">
                                <input class="btn btn-link" type="submit" name="bouton-demande-modification" value="Modifier">
                            </form>
                            <form name="form-supprimer-article" style="display:inline-block" action="blogue.php#retroaction" method="post">
                                <input type="hidden" name="article-id" value="<?= $article->getId() ?>">
                                <input type="hidden" name="blogue-id" value="<?= $blogue->getId() ?>">
                                <input class="btn btn-link" type="submit" name="bouton-supprimer" value="Supprimer">
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <br>
            <hr>
            <br>

            <div id="retroaction"></div>
            <?php require_once '../includes/retroaction.php'; ?>

            <form class="mt-5 mb-5" name="form-ajouter-modifier-article" action="blogue.php#retroaction" method="post">
                <div>
                    <label>Titre : <input type="text" name="titre" value="<?= echapperHtml($titre ?? '') ?>"></label>
                </div>

                <div>
                    <p>Texte :</p>
                    <div><textarea name="texte" cols="100" rows="10"><?= echapperHtml($texte ?? '') ?></textarea></div>
                </div>

                <div>
                    Publier l'article ?
                    <label><input type="radio" name="publie" value="true" <?= $publie ? 'checked' : ''  ?>>Oui</label>
                    <label><input type="radio" name="publie" value="false" <?= $publie ? '' : 'checked'  ?>>Non</label>
                </div>

                <div>
                    Choisissez les tags :
                    <?php foreach ($refTags as $tag) : ?>
                        <label class="me-3"><input type="checkbox" name="tags[]" value="<?= $tag->getId() ?>" <?= in_array($tag->getId(), $tagsIds) ? 'checked' : '' ?>><?= echapperHtml($tag->getNom()) ?></label>
                    <?php endforeach; ?>
                </div>

                <input type="hidden" name="blogue-id" value="<?= $blogue->getId() ?>">

                <?php if (isset($articleAModifier)) : ?>
                    <input type="hidden" name="article-id" value="<?= $articleAModifier->getId() ?>">
                    <input type="submit" name="bouton-modifier" value="Modifier">
                    <input type="submit" name="bouton-annuler" value="Annuler">
                <?php else : ?>
                    <div class="mt-3"><input type="submit" name="bouton-ajouter" value="Ajouter"></div>
                <?php endif; ?>
            </form>
        <?php else : ?>
            <?php require_once '../includes/retroaction.php'; ?>
        <?php endif; ?>
    </section>

    <?php require_once '../includes/pied.php'; ?>
</body>

</html>