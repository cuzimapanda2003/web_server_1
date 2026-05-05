<?php
require_once '../src/bootstrap.php';

$blogueDao = new BlogueDao($connexionBd);
$blogues = $blogueDao->selectAll();


?>

<!doctype html>
<html>

<head>
    <?php require_once '../includes/head.php' ?>
    <title>Mon premier site web en php</title>
</head>

<body>
    <?php require_once '../includes/entete.php'; ?>

    <section id="contenu">
        Les blogues:

        <div class="d-flex flex-wrap justify-content-around">
            <?php foreach ($blogues as $blogue): ?>

                <div class="d-flex justify-content-around flex-wrap p-2">
                    <div class="card p-2" style="width: 20rem;">
                        <img src="<?= $blogue->getBlogueur()->getCheminAvatar() ?? 'assets/img/image-profil-place-holder.png' ?>"
                            class="card-img-top" alt="...">
                        <div class="card-body">
                            <a href="blogue.php?blogue-id=<?= $blogue->getId() ?>">
                                <h4 class="card-title"><?=$blogue->getNom()?></h4>
                            </a>
                            <i class="card-title small">
                                Par <?= $blogue->getBlogueur()->getPrenom() ?>     <?= $blogue->getBlogueur()->getNom() ?>
                            </i>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    </section>

    <?php require_once '../includes/pied.php'; ?>
</body>

</html>