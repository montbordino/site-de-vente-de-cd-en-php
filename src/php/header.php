<header>
    <link rel="stylesheet" type="text/css" href="../../public/scss/header.css">
    <div class="logo">
        <img src="../../public/images/logo.png" alt="Logo">
    </div>
    <nav>
        <!-- rien à voir pour le moment ici :) -->
    </nav>
    <div class="login-info">
        <?php
        session_start();

        $emplacement = debug_backtrace()[0]['file']; // path absolut du fichier appelant header.php
        $dernier_dir = basename(dirname($emplacement)); // dossier contenant le fichier appelant header.php
        if ($dernier_dir == "php"){
            $lien = "";
        }
        else { // le fichier est index.php
            $lien = "src/php/";
        }

        if (isset($_SESSION['email'])) {
            $lien .= 'deconnexion.php';
            echo "<a href=$lien>Connecté avec " . $_SESSION['email'] . ".</a>";
        } else {
            $lien .= 'connexion.php';
            echo "<a href=$lien>connexion</a>";
        }
        ?>
    </div>
</header>