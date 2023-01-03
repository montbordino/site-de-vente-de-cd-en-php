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
        echo '<img src=../../' . $resultat['IMAGE'] .' alt="couverture du cd" width="200px">';
        echo '<div class="informations">';
            echo '<h3> Titre : ' . $resultat['TITRE'] . '</h3>';
            echo '<p> Artiste : ' . $resultat['ARTISTE'] . '</p>';
            echo '<p> Prix : ' . $resultat['PRIX'] . '€</p>';
            echo '<p> Genre : ' . $resultat['GENRE'] . '</p>';
        echo '</div>';
    ?>
        <form action="ajout_panier.php" method="post">
            <input type="hidden" name="id" value="<?php echo $resultat['ID']; ?>">
            <label for="quantite">Quantité</label>
            <input type="number" name"quantite" value="1" min="1" max="10">
            <br> <br>
            <input type="submit" value="Ajouter au panier">
        </form>
    </main>
</body>
</html>

