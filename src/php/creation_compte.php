<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>création compte</title>
    <link rel="stylesheet" type="text/css" href="../../public/scss/connexion.css">
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="centre">
        <form action="creation_compte.php" method="post">
            <label for="nom">nom</label>
            <input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? "" ?>" required> <br>
            <label for="prenom">prenom</label>
            <input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? "" ?>" required> <br>
            <label for="email">email</label>
            <input type="email" name="email" id="email" value="<?php echo $_POST['email'] ?? "" ?>" required> <br>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" value="<?php echo $_POST['password'] ?? "" ?>" required> <br>
            <label for="password2">Confirmation du mot de passe</label>
            <input type="password" name="password2" id="password2" value="<?php echo $_POST['password2'] ?? "" ?>" required> <br>
            <input type="submit" name="submit" value="Créer le compte">
        </form>
    </div>
</body>
</html>


<?php
    // ouverture de la base de données utilisable avec '$bd'
    require_once('../BD/ouverture_bd.php');

    // si le formulaire a été envoyé
    if(isset($_POST['submit'])){
        // on récupère les données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];
        // On hash les mdp avant meme de les enregistrer dans une variable
        $password = hash("sha256", $_POST['password']);
        $password2 = hash("sha256", $_POST['password2']);

        // on vérifie que l'email n'est pas déjà utilisé
        if (!empty($bd)) { // si l'ouverture de la base de données a réussi
            $stmt = $bd->prepare("SELECT * FROM CLIENT WHERE email = :email");
        }
        else {
            echo "Erreur d'ouverture de la base de données";
            die();
        }
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $result = $stmt->fetchAll();

        if(count($result) == 0) {
            // on vérifie que les mots de passe sont identiques
            if($password == $password2) {
                // on ajoute le client à la base de données
                $sql = "INSERT INTO CLIENT (PRENOM, NOM, EMAIL, MOT_DE_PASSE) VALUES (:prenom, :nom, :email, :password)";
                $stmt = $bd->prepare($sql);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':prenom', $prenom);
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':password', $password);
                $stmt->execute();
                // on redirige vers la page de connexion pour que l'utilisateur puisse se connecter
                header('Location: connexion.php');
            }
            else {
                echo "Les mots de passe ne sont pas identiques";
            }
        }
        else {
            echo "Cet email est déjà utilisé avec un autre compte";
        }
    }

