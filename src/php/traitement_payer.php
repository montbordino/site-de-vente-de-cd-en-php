<?php
    require_once("../BD/ouverture_bd.php");
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }


    if (isset($_POST["submit"])) {
        $n_carte = $_POST["carte"];
        $date = $_POST["date"];
        $crypto = $_POST["crypto"];

        // verification si le numéro de carte est valide
        if(($n_carte[0] == substr($n_carte, -1)) && (strlen($n_carte) == 16)){
            // verification si la date est inferieur a la date actuelle - 3 mois
            if($date > date("Y-m-d", strtotime("+3 months"))){
                // verification si le cryptogramme est valide
                if(strlen($crypto) == 3){
                    if(!empty($bd)) {
                        // suppression des produits du panier
                        $stmt = $bd->prepare("DELETE FROM panier WHERE ID_CLIENT = :id_client");
                        $stmt->execute(['id_client' => $_SESSION['id']]);
                        $stmt->closeCursor();

                        mail($_POST["email"], "Confirmation de commande", "Votre commande chez CD SHOP a bien été prise en compte. Vous recevrez un mail de confirmation de la part de notre partenaire de livraison.");
                        header("Location: resultat_payer.php");
                    }

                }
                else{
                    $erreur = "Cryptogramme invalide";
                    header("Location: payer.php?erreur=".$erreur);
                }
            }
            else{
                $erreur = "Date invalide";
                header("Location: payer.php?erreur=".$erreur);
            }
        }
        else{
            $erreur = "Numero de carte invalide";
            header("Location: payer.php?erreur=".$erreur);
        }
    }
