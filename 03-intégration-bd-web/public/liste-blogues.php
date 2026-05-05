<?php
require_once "../src/bootstrap.php";
$blogueDao = new BlogueDao($connexionBd);
$blogues = $blogueDao->selectAll();
?>

<!doctype html>
<html>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Liste des blogues</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

    <section id="contenu">
        <h2>Les blogues :</h2>
        <div class="d-flex justify-content-around flex-wrap p-2">
            <?php foreach ($blogues as $blogue) : ?>
                <div class="card p-3" style="width: 20rem;">
                    <img style="height: 15rem;" src="<?= $blogue->getBlogueur()->getCheminAvatar() != null ? echapperHtml($blogue->getBlogueur()->getCheminAvatar()) : 'assets/img/image-profil-place-holder.png' ?>" alt="...">
                    <div class="card-body">
                        <a href="blogue.php?blogue-id=<?= $blogue->getId() ?>">
                            <h4 class="card-title"><?= echapperHtml($blogue->getNom()) ?></h4>
                        </a>
                        <i class="card-title small">Par <?= echapperHtml($blogue->getBlogueur()->getPrenom()) ?> <?= echapperHtml($blogue->getBlogueur()->getNom()) ?></i>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php require_once '../includes/pied.php'; ?>
</body>

</html>