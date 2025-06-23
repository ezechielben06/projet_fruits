<?php
    if(!isset($_GET['pg'])){
        include("acceuil.php");
    }
    else{
        switch($_GET['pg']){
            case 'acceuil': include("acceuil.php");
            break;
            case 'produits': include("products.php");
            break;
            case 'auteur': include("auteurs.php");
            break;
            case 'connecte': include("connecte.php");
            break;
            case 'confirm': include("confirmation.php");
            break;
            case 'recherche': include("recherche.php");
            break;
            case 'send': include("traite.php");
            break;
            case 'deconnexion':
                session_destroy();
                header('Location: index.php?pg=connecte');
                exit;
                break;
            default: include("acceuil.php");
        }
    }