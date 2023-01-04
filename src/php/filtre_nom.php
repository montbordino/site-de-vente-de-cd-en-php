<?php
    session_start();
    if(isset($_POST['submit'])) {
        $recherche = $_POST['recherche']; // chaine de caractère cherché par l'utilisateur
        $_SESSION['sql'] = 'SELECT * FROM CD WHERE TITRE LIKE "%' . $recherche . '%" AND QUANTITE > 0 ORDER BY TITRE';
        header('Location: ../../index.php?recherche=' . $recherche);
    }