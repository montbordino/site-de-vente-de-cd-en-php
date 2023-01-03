<?php
// permet d'ajouter facilement un cd à la base de données
// prévient contre les erreurs suivantes :
// - erreur de connexion à la base de données
// - tous les champs ne sont pas remplis
// - l'image n'est pas une image
// - l'image est déjà dans la base de données




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
    Titre: <input type="text" name="titre" required><br>
    Artiste: <input type="text" name="artiste" required><br>
    Image: <input type="file" name="image" required><br>
    Prix: <input type="text" name="prix" required><br>
    Quantité: <input type="text" name="quantite" required><br>
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
        $direction = "../../public/images/couverture/" . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $direction)) {
            // l'image a été téléchargée avec succès
            $direction = str_replace("../../", "", $direction); // chemin relatif de l'image pour index.php
            if (!empty($bd)) { // si l'ouverture de la base de données a réussi
                // test si le cd existe déjà
                $stmt = $bd->prepare("SELECT * FROM cd WHERE TITRE = :titre AND ARTISTE = :artiste");
                $stmt->bindParam(':titre', $titre);
                $stmt->bindParam(':artiste', $artiste);
                $stmt->execute();
                $cd = $stmt->fetch();
                if ($cd) { // si le cd existe déjà
                    echo "Ce cd existe déjà";
                } else { // si le cd n'existe pas
                    // ajout de l'image dans la base de données
                    $stmt = $bd->prepare("INSERT INTO CD (titre, artiste, image, prix, quantite, genre) VALUES (:titre, :artiste, :image, :prix, :quantite, :genre)");
                    $stmt->bindParam(':titre', $titre);
                    $stmt->bindParam(':artiste', $artiste);
                    $stmt->bindParam(':image', $direction);
                    $stmt->bindParam(':prix', $prix);
                    $stmt->bindParam(':quantite', $quantite);
                    $stmt->bindParam(':genre', $genre);
                    $stmt->execute();
                    echo "Le cd a été ajouté avec l'image suivante: <br>";
                }
            } else {
                echo "Erreur d'ouverture de la base de données";
            }
        } else {
            echo "Erreur lors du téléchargement de l'image";
        }
    }
    else {
        echo "L'image doit être au format jpg ou png";
    }

}
?>
</body>
</html>
