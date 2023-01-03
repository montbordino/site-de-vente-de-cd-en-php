<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../public/scss/connexion.css">
    <title>page de connexion</title>
</head>
<body>
    <?php include_once('header.php'); ?>
    <div class="centre">
        <form action="connexion.php" method="post">
            <label for="email">email</label>
            <input type="email" name="email" id="email" required value="<?php echo $_POST['email'] ?? ''?>"> <br>
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" required value="<?php echo $_POST['password'] ?? ''?>"> <br>
            <input type="checkbox" name="remember" id="remember">
            <label for="remember">Se souvenir de moi</label> <br>
            <input type="submit" name="submit" value="Connexion">
        </form>
    </div>
</body>
</html>

<?php
    /**
     * @BUT: Ce code php verifie si l'utilisateur existe dans la base de données
     * si oui on le connecte en ajoutant son email dans la variable de session $_SESSION['email'] et on le redirige vers la page d'accueil
     * s'il a coché la case "se souvenir de moi" on ajoute son email dans le cookie $_COOKIE['email'] pendant une heure
     * sinon on lui affiche un message d'erreure.
     *
     * @input : aucune variable de session n'est requise
     * @return: $_SESSION['email'] et ou $_COOKIES['email']
     */
    
    // ouverture de la base de données utilisable avec '$bd'
    require_once('../BD/ouverture_bd.php');

    if(isset($_POST["submit"])){
        $email = $_POST["email"];
        $password = hash("sha256", $_POST["password"]);
        if (!empty($bd)) { // si l'ouverture de la base de données a réussi
            $stmt = $bd->prepare("SELECT * FROM CLIENT WHERE EMAIL = :email AND MOT_DE_PASSE = :password");
        }
        else {
            echo "Erreur d'ouverture de la base de données";
            die();
        }
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $result = $stmt->fetchAll();
        // si le client existe dans la bd
        if(count($result) == 1){
                // on ajoute l'email et l'id dans des variables de session
                $_SESSION["email"] = $email;
                $_SESSION["id"] = $result[0]["ID_CLIENT"];
                // si l'utilisateur a coché la case "se souvenir de moi"
                if(!empty($_POST["remember"])) {
                    // on ajoute l'email dans le cookie
                    setcookie("email", $email, time() + 3600);
                    setcookie("id", $result[0]["ID_CLIENT"], time() + 3600);
                }
                // on redirige vers la page d'accueil
                header("Location: ../../index.php");
        }
        else{
            var_dump($result);
            echo "adresse mail ou mot de passe incorrect";
        }
    }

