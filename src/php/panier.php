<?php
    include_once("header.php");
    require_once("../BD/ouverture_bd.php");
    ?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../public/scss/panier.css">
    <title>Document</title>
</head>
<body>
    <main>
        <div id="articles">
            <?php
            if(!empty($_SESSION["email"])) {
                if(!empty($bd)){
                    $query = 'SELECT CD.ID, CD.TITRE, CD.ARTISTE, CD.IMAGE, CD.PRIX, PANIER.QUANTITE
                  FROM PANIER
                  INNER JOIN CD ON PANIER.ID_CD = CD.ID
                  WHERE PANIER.ID_CLIENT = :id_client';
                    $stmt = $bd->prepare($query);
                    $stmt->execute(['id_client' => $_SESSION['id']]);
                    $panier = $stmt->fetchAll();

                    foreach ($panier as $item) {
                        echo '<div>';
                        echo '<img src="../../'.$item['IMAGE'].'" alt="'.$item['TITRE'].'">';
                            echo '<div class="informations">';
                                echo '<h3>'.$item['TITRE'].'</h3>';
                                echo '<p>'.$item['ARTISTE'].'</p>';
                                echo '<p>'.$item['PRIX'].' €</p>';
                                echo '<p>Quantité : '.$item['QUANTITE'].'</p>';
                            echo '</div>';
                        echo '</div>';
                    }

                }
                else{
                    $erreur = "connexion a la base de donnees echouee";
                    header("Location: ". $_SERVER['HTTP_REFERER']. "?erreur=".$erreur);
                }
            }
            else {
                header("Location: ". $_SERVER['HTTP_REFERER']. "?erreur=Vous devez vous connecter pour acceder a votre panier");
            }
            ?>
        </div>
        <aside>
            <!-- Calcul du prix total -->
            <?php
                    $query = 'SELECT CD.PRIX AS PRIX, PANIER.QUANTITE AS QTE
                  FROM PANIER
                  INNER JOIN CD ON PANIER.ID_CD = CD.ID
                  WHERE PANIER.ID_CLIENT = :id_client';
                    $stmt = $bd->prepare($query);
                    $stmt->execute(['id_client' => $_SESSION['id']]);
                    $total = $stmt->fetchAll();
                    $resultat = 0;
                    foreach ($total as $item) {
                        $item['PRIX'] = str_replace(',', '.', $item['PRIX']);
                        $resultat += floatval($item['PRIX']) * floatval($item['QTE']);
                    }
            ?>
            <form method="post" action=<?php echo "payer.php?total=" . $resultat ?>>
                <h1>Mon panier</h1>
                <div id="total">
                    <input type="hidden" name="total" value="<?php echo $resultat; ?>">
                    <p >Total : <?php  echo $resultat ?> </p>
                    <input type="submit" name="submit" value="Valider mon panier">
                </div>
            </form>
    </main>

</body>
</html>