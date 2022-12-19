<?php
    /**
     * Ce fichier est appelé par les autres fichiers PHP pour se connecter à la base de données
     * Comme ça on peut facilement changer entre la base de données locale et la base de données lakarxela
     */

    try {
        $bd = new PDO('sqlite:'.dirname(__FILE__).'/BD');
        $bd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
    } catch(Exception $e) {
        echo "Impossible d'accéder à la base de données SQLite : " . $e->getMessage();
        die();
    }

    /**
     * testBD
     *
     * Teste la connexion à la base de données.
     */
    function testBD() {
        global $bd;

        $sql = "SELECT * FROM CLIENT";
        $stmt = $bd->prepare($sql);

        $stmt->execute();

        $result = $stmt->fetchAll();

        var_dump($result);

    }
?>