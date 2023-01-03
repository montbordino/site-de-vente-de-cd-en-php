<!-- Affiche les détails d'un CD renseigné par son id
     paramètres : ID ⇾ id du CD
    -->

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Détails cd</title>
    <link rel="stylesheet" type="text/css" href="../../public/scss/detail_cd.css">
</head>
<body>
    <?php
    include_once("header.php");
    require_once("../BD/ouverture_bd.php");
    $id = $_GET['id'];
    if (!empty($bd)) { // si l'ouverture de la base de données a réussi
        $sql = "SELECT * FROM CD WHERE ID = :id";
    } else {
        echo "Erreur d'ouverture de la base de données";
        die();
    }
    $requete = $bd->prepare($sql);
    $requete->bindParam(':id', $id);
    $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_ASSOC);
    echo "<main>";
        echo '<img src=../../' . $resultat['IMAGE'] .' alt="couverture du cd">';
        echo '<div id="partie-droite">';
            echo '<section class="informations">';
                echo '<h1> ' . $resultat['TITRE'] . '</h1>';
                echo '<p> ' . $resultat['ARTISTE'] . '</p>';
                echo '<p> ' . $resultat['PRIX'] . '€</p>';
                echo '<p> Genre : ' . $resultat['GENRE'] . '</p>';
            echo '</section>';
    ?>
        <section class="formulaire">
            <form action="ajout_panier.php" method="post">
                <input type="hidden" name="id" value="<?php echo $resultat['ID']; ?>">
                <label for="quantite">Quantité</label>
                <input type="number" name="quantite" value="1" min="1" max=<?php echo min(10, $resultat['QUANTITE']);?>>
                <br> <br>
                <input type="submit" name="submit" value="Ajouter au panier">
            </form>
        </section>
    </main>
</body>
</html>

