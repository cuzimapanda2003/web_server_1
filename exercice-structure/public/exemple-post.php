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

        <?php
        if (!empty($_POST)):
            
        ?>
            <p>Prénom : <?=$_POST['prenom']?></p>
            <p>Nom : <?=$_POST['nom']?></p>
            <p>Grandeur : <?=$_POST['grandeur']?></p>
            <p>Date de naissance : <?=$_POST['date-naissance']?></p>
            <p>Je suis : <?=$_POST['sexe']?></p>
            <p>Situation : <?=$_POST['situation']?></p>
            <p>Présentation : <?=$_POST['presentation']?></p>

        <?php endif; ?>
    

        <form name="formulaire" action="exemple-post.php" method="post" class="form">



            <div><label>Prénom : <input type="text" name="prenom"></label></div>
            <div><label>Nom : <input type="text" name="nom"></label></div>
            <div><label>Grandeur : <input type="number" name="grandeur" min="0"> cm</label></div>
            <div><label>Date de naissance : <input type="date" name="date-naissance"></label></div>
            <div><label><input type="radio" value="1" name="sexe">homme</label>
                <label><input type="radio" value="2" name="sexe">femme</label>
            </div>
            <div><label><input type="checkbox" name="rencontres[]">Voulez vous rencontrer un homme</label></div>
            <div><label><input type="checkbox" name="rencontres[]">Voulez vous rencontrer une Femme</label></div>
            <div>
                <label>
                    Situation :
                    <select name="situation">
                        <option value="1" selected>Célibataire</option>
                        <option value="2">En couple</option>
                        <option value="3">Je ne sais pas</option>
                        <option value="4">C'est compliqué</option>
                        <option value="5">Toutes ces réponses</option>
                    </select>
                </label>
            </div>
            </div>
            <div><textarea name="presentation" cols="30" rows="4">Présentez vous...</textarea></div>
            <input type="hidden" name="id" value="1">
            <div><input type="submit" name="bouton-envoyer" value="Envoyer"></div>



        </form>








    </section>

    <?php require_once '../includes/pied.php' ?>


</body>

</html>