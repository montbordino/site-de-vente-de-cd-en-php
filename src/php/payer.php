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
    <title>page de payement</title>
    <link rel="stylesheet" href="../../public/scss/payer.css">
</head>
<body>
    <main>
        <section id="recap">
            <h1>Votre commande</h1>
            <div id="achats">
                <?php
                if(!empty($_SESSION["email"])) {
                    if(!empty($bd)){
                        $query = 'SELECT CD.ID, CD.TITRE, CD.ARTISTE, CD.PRIX, PANIER.QUANTITE
                  FROM PANIER
                  INNER JOIN CD ON PANIER.ID_CD = CD.ID
                  WHERE PANIER.ID_CLIENT = :id_client';
                        $stmt = $bd->prepare($query);
                        $stmt->execute(['id_client' => $_SESSION['id']]);
                        $panier = $stmt->fetchAll();

                        foreach ($panier as $item) {
                            echo '<div>';
                            echo '<span><strong>quantité</strong> : '.$item['QUANTITE'].'</span>';
                            echo '<span><strong>Titre</strong> : '.$item['TITRE'].'</span>';
                            echo '<span><strong>Artiste</strong> : '.$item['ARTISTE'].'</span>';
                            echo '<span>'.$item['PRIX'].'€</span>';
                            echo '</div>';
                        }
                        echo '<div id="total">';
                        echo '<span><strong>Total</strong> : '.$_SESSION['total'].'€</span>';
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
        </section>
        <section id="payement">
            <h1>Payement</h1>
            <form action="traitement_payer.php" method="post">
                <div>
                    <label for="nom">Nom</label>
                    <input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? '' ?>" required>
                </div>
                <div>
                    <label for="prenom">Prénom</label>
                    <input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? '' ?>" required>
                </div>
                <div>
                    <label for="adresse">Adresse</label>
                    <input type="text" name="adresse" id="adresse" value="<?php echo $_POST['adresse'] ?? '' ?>" required>
                </div>
                <div>
                    <label for="ville">Ville</label>
                    <input type="text" name="ville" id="ville" value="<?php echo $_POST['ville'] ?? '' ?>" required>
                </div>
                <div>
                    <label for="code_postal">Code postal</label>
                    <input type="text" name="code_postal" id="code_postal" value="<?php echo $_POST['code_postal'] ?? '' ?>" required>
                </div>
                <div>
                    <label for="pays">Pays</label>
                    <input type="text" name="pays" id="pays" value="<?php echo $_POST['pays'] ?? '' ?>" required>
                </div>
                <div>
                    <label for="telephone">Téléphone</label>
                    <input type="tel" name="telephone" id="telephone" value="<?php echo $_POST['telephone'] ?? '' ?>" required>
                </div>
                <div>
                    <label for="carte">Numéro de carte</label>
                    <input type="text" name="carte" id="carte"  required>
                </div>
                <div>
                    <label for="date">Date d'expiration</label>
                    <input type="date" name="date" id="date" required>
                </div>
                <div>
                    <label for="crypto">Cryptogramme</label>
                    <input type="text" name="crypto" id="crypto" required>
                </div>
                <div>
                    <input type="submit" name="submit" value="Payer">
                </div>
            </form>
        </section>
    </main>
</body>
</html>