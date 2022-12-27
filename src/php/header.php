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
        if (isset($_SESSION['email'])) {
            echo "<a href='logout.php'>Connecté avec " . $_SESSION['email'] . ".</a>";
        } else {
            echo '<a href="connexion.php">Connexion</a>';
        }
        ?>
    </div>
</header>