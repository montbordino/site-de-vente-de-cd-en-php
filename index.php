<?php
// cette page à pour but d'accueillir l'utilisateur et de lui présenter le site, il n'a pas besoin de se connecter pour y accéder

include_once('src/php/header.php');
require_once('src/BD/ouverture_bd.php');

?>
<script>
    // ce script garde la position de scroll de la page lors du chargement de la page.
    document.addEventListener("DOMContentLoaded", function() {
        var posY = localStorage.getItem('posY');
        if (posY) window.scrollTo(0, posY);
    });

    window.onbeforeunload = function() {
        localStorage.setItem('posY', window.scrollY);
    };

</script>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="public/scss/index.css">
    <title>Accueil</title>
</head>
<body>
   
    
    <div class="sous-header">
        <div class="bg">
            <img src="public/images/bg_index.jpeg" alt="image floue de cds">
        </div>
        <div class="contenu">
            <h1>Bienvenue</h1>
            <br> <br>
            <p>Si vous cherchez des cd vous êtes au bon endroit</p>
            <br> <br>
        </div>
    </div>

    <main id="main">
            <form id="formulaire-recherche" method="post" action="src/php/filtre_nom.php">
                <label for="recherche">Recherche</label>
                <input type="text" name="recherche" value="<?php echo $_GET['recherche'] ?? "" ?>">
                <input type="submit" name="submit">
            </form>

            <section id="produits">
                <?php
                if (!empty($bd)) { // si l'ouverture de la base de données a réussi
                    if(isset($_SESSION['sql'])) {
                        $sql = $_SESSION['sql'];
                        unset($_SESSION['sql']);
                    } else {
                        $sql = 'SELECT * FROM CD WHERE QUANTITE > 0 ORDER BY TITRE';
                    }
                    $requete = $bd->query($sql);
                    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultat as $cd) {
                        echo '<div class="article">';
                            $lien = 'src/php/detail_cd.php?id=' . $cd["ID"];
                            echo '<a href=' . $lien . '>';
                                echo '<div class="filtre"></div>';
                                echo '<h3>' . $cd['TITRE'] . '</h3>';
                                echo '<img src=' . $cd['IMAGE'] .' alt="couverture du cd" width="200px">';
                                echo '<p>' . $cd['ARTISTE'] . '</p>';
                                echo '<p>' . $cd['PRIX'] . '€</p>';
                            echo '</a>';
                        echo '</div>';
                    }
                }
                else {
                    echo 'Erreur de connexion à la base de données';
                }
                ?>
            </section>
    </main>
</body>
</html>

