<?php
session_start();
require_once('connexion.php');

// Génération de la facture
require_once('facture.php');

// Vider le panier après la commande
unset($_SESSION['panier']);