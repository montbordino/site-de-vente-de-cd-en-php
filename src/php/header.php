<?php 
if(session_status() === PHP_SESSION_NONE) session_start();
    // ici on gere les liens utilisé dans le header en fonction du fichier qui l'appel
    $emplacement = debug_backtrace()[0]['file']; // path absolut du fichier appelant header.php
    $dernier_dir = basename(dirname($emplacement)); // dossier contenant le fichier appelant header.php
    if ($dernier_dir == "php"){
        $lien_connexion = "";
        $lien_logo = "../../index.php";
        $img_logo = "../../public/images/logo.png";
        $img_caddie =  "../../public/images/caddie.svg";
        $lien_caddie = "panier.php";
        $scss = "../../public/scss/header.css";
        $creer_cd = "creer_cd.php";
        $gerer_utilisateurs = "gerer_utilisateurs.php";
        $gerer_cd = "gerer_cd.php";
    }
    else { // le fichier est index.php
        $lien_connexion = "src/php/";
        $lien_logo = "index.php";
        $img_logo = "public/images/logo.png";
        $img_caddie =  "public/images/caddie.svg";
        $lien_caddie = "src/php/panier.php";
        $scss = "public/scss/header.css";
        $creer_cd = "src/php/creer_cd.php";
        $gerer_utilisateurs = "src/php/gerer_utilisateurs.php";
        $gerer_cd = "src/php/gerer_cd.php";
    }
    ?>
<link rel="stylesheet" type="text/css" href=<?php echo $scss; ?>>
<header>
    <div class="logo">
        <?php
            echo  "<a href=$lien_logo><img src=$img_logo alt='Logo'></a>";
        ?>
    </div>
    <nav>
        <?php // acces administrateur (email: admin@admin.com / mdp: admin) 
        if(isset($_SESSION['email']) == "admin@admin.com"){
            if ($_SESSION['email'] == "admin@admin.com") {
                echo "<a href= $creer_cd> creer_cd.php </a>";
                echo "<a href= $gerer_utilisateurs> gerer_utilisateurs.php </a>";
                echo "<a href= $gerer_cd> gerer_cd.php </a>";
            }
        }
        
        ?>
    
        <!-- affichage du pannier -->
        <a href=<?php echo $lien_caddie ;?> ><img src=<?php echo $img_caddie ?> alt='caddie'></a>

        <!-- affichage du bouton connexion -->
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
    </nav>
</header>
<?php
    echo '<div id="affichage"></div>';
    if (isset($_GET['erreur'])) {
        echo '<script>document.getElementById("affichage").classList.add("erreur");</script>';
        echo '<script>document.getElementById("affichage").innerHTML = "Erreur : ' . $_GET['erreur'] . '";</script>';
        echo '<script>setTimeout(function() { document.getElementById("affichage").classList.remove("erreur"); 
                                              document.getElementById("affichage").style.visibility = "hidden";}, 3000);</script>';
        unset($_GET['erreur']);
    }
    if (isset($_GET['succes'])) {
        echo '<script>document.getElementById("affichage").classList.add("succes");</script>';
        echo '<script>document.getElementById("affichage").innerHTML = "Succès : ' . $_GET['succes'] . '";</script>';
        echo '<script>setTimeout(function() { document.getElementById("affichage").classList.remove("succes"); 
                                              document.getElementById("affichage").style.visibility = "hidden";}, 3000);</script>';
        unset($_GET['erreur']);
    }
?>