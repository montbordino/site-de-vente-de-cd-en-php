<?php
// cette page à pour but d'accueillir l'utilisateur et de lui présenter le site, il n'a pas besoin de se connecter pour y accéder

include_once('src/php/header.php');
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
            <a href="shop.php"><button> commencer mes achats </button></a>
        </div>
    </div>
</body>
</html>
