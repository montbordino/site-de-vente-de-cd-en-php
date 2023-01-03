<?php
    // cette page ajoute l'article envoyé en paramètre ["ID_ARTICLE"] au panier
    // paramètres : ID_ARTICLE ⇾ id de l'article à ajouter
    //              QUANTITE ⇾ quantité de l'article à ajouter
    //              ID_CLIENT ⇾ id du client qui ajoute l'article au panier

    // si l'utilisateur n'est pas connecté, on le redirige vers la page de détail de l'article avec un message d'erreur
    // si l'utilisateur est connecté, on ajoute l'article au panier de l'utilisateur
        // si l'article est déjà dans le panier, on augmente sa quantité
        // si l'article n'est pas dans le panier, on l'ajoute avec une quantité de ["QUANTITE"]

    require_once("../BD/ouverture_bd.php");
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_POST["submit"])){
        if(!empty($_SESSION["email"])){
            // L'utilisateur est connecté
            if(!empty($bd)){
                // on vérifie si l'article est déjà dans le panier
                $requete = $bd->prepare("SELECT * FROM PANIER WHERE ID_CLIENT = :id_client AND ID_CD = :id_cd");
                $requete->bindParam(":id_client", $_SESSION["id"]);
                $requete->bindParam(":id_cd", $_POST["id"]);
                $requete->execute();
                $resultat = $requete->fetch(PDO::FETCH_ASSOC);

                if($resultat){
                    // L'article est déjà dans le panier
                    $requete = $bd->prepare("UPDATE PANIER SET QUANTITE = QUANTITE + :quantite WHERE ID_CLIENT = :id_client AND ID_CD = :id_cd");
                } else {
                    // L'article n'est pas dans le panier
                    $requete = $bd->prepare("INSERT INTO PANIER (ID_CLIENT, ID_CD, QUANTITE) VALUES (:id_client, :id_cd, :quantite)");
                }
                $requete->bindParam(":id_client", $_SESSION["id"]);
                $requete->bindParam(":id_cd", $_POST["id"]);
                $requete->bindParam(":quantite", $_POST["quantite"]);
                $requete->execute();

                // on retire la quantité de l'article ajouté au panier de la quantité en stock
                $requete = $bd->prepare("UPDATE CD SET QUANTITE = QUANTITE - :quantite WHERE ID = :id_cd");
                $requete->bindParam(":id_cd", $_POST["id"]);
                $requete->bindParam(":quantite", $_POST["quantite"]);
                $requete->execute();

                header("Location: ../php/detail_cd.php?id=" . $_POST["id"] . "&succes=Article ajoute au panier");
            }
        }
        else{
            $erreur = "connexion";
            header("Location: ../php/detail_cd.php?id=".$_POST["id"]."&erreur=".$erreur);
        }
    }
    else{
        $erreur = "vous devez vous connecter pour ajouter un article au panier";
        header("Location: ../php/detail_cd.php?id=".$_POST["id"]."&erreur=".$erreur);
    }
