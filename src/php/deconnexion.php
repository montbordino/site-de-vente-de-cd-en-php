<?php
    session_start();
    session_unset();
    session_destroy();
    if (isset($_COOKIE["email"])){
        unset($_COOKIE['email']);
    }
    header("Location: ../../index.php");