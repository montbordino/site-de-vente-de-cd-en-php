<header>
    <link rel="stylesheet" type="text/css" href="../../public/scss/header.css">
    <div class="logo">
        <?php
            session_start();

            $emplacement = debug_backtrace()[0]['file']; // path absolut du fichier appelant header.php
            $dernier_dir = basename(dirname($emplacement)); // dossier contenant le fichier appelant header.php
            if ($dernier_dir == "php"){
                $lien_connexion = "";
                $lien_img = "../../index.php";
            }
            else { // le fichier est index.php
                $lien_connexion = "src/php/";
                $lien_img = "index.php";
            }
            echo  "<a href=$lien_img><img src='../../public/images/logo.png' alt='Logo'></a>";
            ?>
    </div>
    <nav>
        <!-- rien à voir pour le moment ici :) -->
    </nav>
    <div class="login-info">
        <?php

        if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {
            if (isset($_COOKIE['email'])) { // si l'utilisateur a coché la case "se souvenir de moi"
                $_SESSION['email'] = $_COOKIE['email'];
                $_SESSION['id'] = $_COOKIE['id'];
            }
            $lien_connexion .= 'deconnexion.php';
            echo "<a href=$lien_connexion>Connecté avec " . $_SESSION['email'] . ".</a>";
        } else {
            $nom_fic = basename(debug_backtrace()[0]['file']); // nom du fichier appelant header.php
            if ($nom_fic == "connexion.php"){
                echo "<a href='creation_compte.php'>je n'ai pas encore de compte</a>";
            }
            else{
                $lien_connexion .= 'connexion.php';
                echo "<a href=$lien_connexion>connexion</a>";
            }
        }
        ?>
    </div>
</header>