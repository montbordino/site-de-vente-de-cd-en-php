<?php
    include_once('../BD/ouverture_bd.php');
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Création d'un cd</title>
</head>
<body>
<h1>Créer un cd</h1>
<form action="" method="post" enctype="multipart/form-data">
    Titre: <input type="text" name="titre"><br>
    Artiste: <input type="text" name="artiste"><br>
    Image: <input type="file" name="image" required><br>
    Prix: <input type="text" name="prix"><br>
    Quantité: <input type="text" name="quantite"><br>
        <?php // affichage des genres avec la base de données
            if (!empty($bd)){
                echo "Genre : <select name='genre'>"; // on créé la liste déroulante en php pour verifier si la base de données est ouverte avant
                $stmt = $bd->prepare("SELECT * FROM genre");
                $stmt->execute();
                $genres = $stmt->fetchAll();
                foreach ($genres as $genre){
                    echo "<option value=".$genre['NOM'].">".$genre['NOM']."</option>";
                }
                echo "</select><br><br>";
            }
            else{
                echo "Erreur de connexion à la base de données";
            }
        ?>
    <input type="submit" name="Envoyer" value="Envoyer">
</form>

<?php
// Vérification de la soumission du formulaire
if (isset($_POST['Envoyer'])) {
    // Récupération des données du formulaire
    $titre = $_POST['titre'];
    $artiste = $_POST['artiste'];
    $prix = $_POST['prix'];
    $quantite = $_POST['quantite'];
    $genre = $_POST['genre'];

    // Vérification de l'extension de l'image
    $extension = pathinfo($_FILES['image']["name"], PATHINFO_EXTENSION);
    if (in_array($extension, array('jpg', 'jpeg', 'png', 'gif', 'jfif'))) {
        print_r($_FILES['image']);
        // Récupération de l'image
        $image = file_get_contents($_FILES['image']['tmp_name']);
        // conversion de l'image pour l'envoyer dans la base de données
        $image_blob = addslashes($image);

        if (!empty($bd)) { // si l'ouverture de la base de données a réussi
            // ajout de l'image dans la base de données
            $stmt = $bd->prepare("INSERT INTO CD (titre, artiste, image, image_type, prix, quantite, genre) VALUES (:titre, :artiste, :image, :image_type, :prix, :quantite, :genre)");
            $stmt->bindParam(':titre', $titre);
            $stmt->bindParam(':artiste', $artiste);
            $stmt->bindParam(':image', $image_blob);
            $stmt->bindParam(':image_type', $extension);
            $stmt->bindParam(':prix', $prix);
            $stmt->bindParam(':quantite', $quantite);
            $stmt->bindParam(':genre', $genre);
            $stmt->execute();
            echo "Le cd a été ajouté";
        } else {
            echo "Erreur d'ouverture de la base de données";
        }
    }
    else {
        echo "L'image doit être au format jpg ou png";
    }

}
?>
</body>
</html>
