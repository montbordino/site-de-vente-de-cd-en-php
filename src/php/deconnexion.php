<?php
/**
 * @BUT: Ce code php supprime les variables de session de l'utilisateur et ses cookies s'il en a.
 *
 * @input : $_SESSION['email'] et ou $_COOKIES['email']
 * @return: None
 */

    session_start();
    session_unset();
    session_destroy();
    if (isset($_COOKIE["email"])){
        unset($_COOKIE['email']);
    }
    header("Location: ../../index.php");