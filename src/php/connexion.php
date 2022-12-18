<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>page de connexion</title>
</head>
<body>
    <form action="connexion.php" method="post">
        <label for="login">Login</label>
        <input type="text" name="login" id="login"> <br>
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password"> <br>
        <input type="checkbox" name="remember" id="remember">
        <label for="remember">Se souvenir de moi</label> <br>
        <input type="submit" value="Connexion">
    </form>
</body>
</html>

<?php
    // ouverture de la base de données utilisable avec '$bd'
    require_once('../BD/ouverture_bd.php');

