<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>création compte</title>
</head>
<body>
<form action="creation_compte.php"  method="post">
    <label for="nom" required >nom</label>
    <input type="text" name="nom" id="nom" value="<?php echo $_POST['nom'] ?? "" ?>"> <br>
    <label for="prenom">prenom</label>
    <input type="text" name="prenom" id="prenom" value="<?php echo $_POST['prenom'] ?? "" ?>"> <br>
    <label for="email">email</label>
    <input type="email" name="email" id="email" value="<?php echo $_POST['email'] ?? "" ?>"> <br>
    <label for="password">Mot de passe</label>
    <input type="password" name="password" id="password" value="<?php echo $_POST['password'] ?? "" ?>"> <br>
    <label for="password2">Confirmation du mot de passe</label>
    <input type="password" name="password2" id="password2" value="<?php echo $_POST['password2'] ?? "" ?>"> <br>
    <input type="submit" value="Créer le compte">

</body>
</html>


<?php
    // ouverture de la base de données utilisable avec '$bd'
    require_once('../BD/ouverture_bd.php');


    