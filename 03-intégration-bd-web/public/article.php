<?php
require_once '../src/bootstrap.php';

$articleDao = new ArticleDao($connexionBd);

$erreurs = [];

$articleId = filter_input(INPUT_GET, 'article-id', FILTER_VALIDATE_INT);
if (is_int($articleId))
{
    $article = $articleDao->select($articleId);
    if ($article != null)
    {
        // On récupère l'ID du blogue pour le lien de retour
        $blogueurId = $article->getAuteur()->getId();
        $blogueDao = new BlogueDao($connexionBd);
        $blogueId = $blogueDao->selectParBlogueurId($blogueurId)->getId();

        // On récupère les commentaires associés à l'article
        $commentaireDao = new CommentaireDao($connexionBd);
        $commentaires = $commentaireDao->selectAllParArticleId($articleId);
        $article->setCommentaires($commentaires);
    }
    else
    {
        $erreurs[] = "Aucun article n'a été trouvé.";
    }
}
else
{
    $erreurs[] = "Aucun article n'a été trouvé.";
}
?>

<!doctype html>
<html>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Page d'article</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

    <section id="contenu">
        <?php if (isset($article)) : ?>
            <div class="pb-4">
                <a class="btn btn-secondary" href="blogue.php?blogue-id=<?= $blogueId ?>">
                    Retour au blogue
                </a>
            </div>

            <?php require_once '../includes/retroaction.php'; ?>

            <div class="card p-2 mb-2 flex-row">
                <img class="card-img-left rounded" style="width: 20rem; height: 20rem;" src="<?= $article->getAuteur()->getCheminAvatar() != null ? echapperHtml($article->getAuteur()->getCheminAvatar()) : 'assets/img/image-profil-place-holder.png' ?>" />
                <div class="card-body">
                    <h3 class="card-title mb-2"><?= echapperHtml($article->getTitre()) ?></h3>
                    <h4 class="card-title mb-2">
                        <?php foreach ($article->getTags() as $tag) : ?>
                            <span class="badge bg-secondary"><?= echapperHtml($tag->getNom()) ?></span>
                        <?php endforeach; ?>
                    </h4>
                    <p class="card-text small text-muted mb-3"><i>Écrit par : <?= echapperHtml($article->getAuteur()->getPrenom()) ?> <?= echapperHtml($article->getAuteur()->getNom()) ?></i></p>
                    <p class="card-text mb-3"><?= echapperHtml($article->getTexte()) ?></p>
                    <p class="card-text small text-muted"><i>Création : <?= $article->getDateCreation()->format('Y-m-d H:i:s') ?></i></p>
                    <p class="card-text small text-muted"><i>Dernière modification : <?= $article->getDateModification()->format('Y-m-d H:i:s') ?></i></p>
                </div>
            </div>

            <div class="d-flex justify-content-end">
                <div class="d-flex p-2 flex-column w-50">
                    <?php foreach ($article->getCommentaires() as $commentaire) : ?>
                        <div class="card p-2 mb-3 flex-row">
                            <img class="card-img-left rounded" style="width: 10rem; height: 10rem;" src="<?= $commentaire->getAuteur()->getCheminAvatar() != null ? echapperHtml($commentaire->getAuteur()->getCheminAvatar()) : 'assets/img/image-profil-place-holder.png/' ?>" />
                            <div class="card-body">
                                <h5 class="card-title mb-3"><?= echapperHtml($commentaire->getAuteur()->getPrenom()) ?> <?= echapperHtml($commentaire->getAuteur()->getNom()) ?> a commenté : </h5>
                                <p class="card-text mb-3"><?= echapperHtml($commentaire->getTexte()) ?></p>
                                <p class="card-text small text-muted"><i>Écrit le <?= $commentaire->getDatePublication()->format('Y-m-d H:i:s') ?></i></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php else : ?>
            <div class="pb-4">
                <a class="btn btn-secondary" href="liste-blogues.php">
                    Retour à la liste des blogues
                </a>
            </div>

            <?php require_once '../includes/retroaction.php'; ?>
        <?php endif; ?>
    </section>

    <?php require_once '../includes/pied.php'; ?>
</body>

</html>