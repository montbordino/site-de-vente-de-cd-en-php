<?php
// cette page à pour but d'accueillir l'utilisateur et de lui présenter le site, il n'a pas besoin de se connecter pour y accéder

include_once('src/php/header.php');
require_once('src/BD/ouverture_bd.php');
?>

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
            <a href="#main"><button> commencer mes achats </button></a>
        </div>
    </div>

    <main id="main">
        <aside>
            <h2>Filtres</h2>
            <form>
                <label for="genre">Genre</label>
                <select name="genre" id="genre">
                    <option value="rock">Rock</option>
                    <option value="pop">Pop</option>
                    <option value="rap">Rap</option>
                    <option value="classique">Classique</option>
                    <option value="jazz">Jazz</option>
                    <option value="metal">Metal</option>
                    <option value="reggae">Reggae</option>
                    <option value="electro">Electro</option>
                    <option value="variété">Variété</option>
                </select>
                <br> <br>
                <label for="ordre">Trier par</label>
                <select name="ordre" id="ordre">
                    <option value="prix">Prix croissant</option>
                    <option value="prix">Prix décroissant</option>
                </select>
                <br> <br>

                <label for="prix">Prix</label>
                <select name="prix" id="prix">
                    <option value="0-20">0-20€</option>
                    <option value="20-50">20-50€</option>
                    <option value="50-100">50-100€</option>
                    <option value="+100">+100</option>
                </select>
                <br> <br>

                <label for="artiste">Artiste</label>
                <input type="text" name="artiste" id="artiste">
                <br> <br>
                <input type="submit" value="Appliquer">
            </form>
        </aside>
        <div id="content">
            <input type="text" placeholder="cherchez un titre">

            <section id="produits">
                <?php
                if (!empty($bd)) { // si l'ouverture de la base de données a réussi
                    $requete = $bd->query('SELECT * FROM CD');
                    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($resultat as $cd) {
                        echo '<div class="article">';
                            $lien = 'src/php/detail_cd.php?id=' . $cd["ID"];
                            echo '<a href=' . $lien . '>';
                                echo '<h3>' . $cd['TITRE'] . '</h3>';
                                echo '<img src=' . $cd['IMAGE'] .' alt="couverture du cd" width="200px">';
                                echo '<p>' . $cd['ARTISTE'] . '</p>';
                                echo '<p>' . $cd['PRIX'] . '€</p>';
                            echo '</a>';
                        echo '</div>';
                    }
                }
                else {
                    echo 'erreur de connexion à la base de données';
                }
                ?>

            </section>
        </div>
    </main>
</body>
</html>
