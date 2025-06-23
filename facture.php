<?php
// session_start();
require_once('connexion.php');
require('FPDF/fpdf.php'); // Assurez-vous que le chemin vers FPDF est correct

class PDF extends FPDF {
    // Variable pour l'image de fond
    private $background;
    
    function __construct($orientation='P', $unit='mm', $size='A4') {
        parent::__construct($orientation, $unit, $size);
        // Charger l'image de fond (remplacez par votre chemin)
        // $this->background = 'images/WhatsApp Image 2025-03-29 à 00.51.59_2bc84a4b.jpg';
    }
    
    // Fonction pour ajouter l'image de fond
    function AddPage($orientation='', $size='', $rotation=0) {
        parent::AddPage($orientation, $size, $rotation);
        if($this->background) {
            $this->Image($this->background, 0, 0, $this->w, $this->h);
            // Réinitialiser la position Y après l'image de fond
            $this->SetY(20);
        }
    }
    
    // En-tête simplifié
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'FACTURE', 0, 1, 'C');
        $this->Ln(10);
    }
    
    // Pied de page
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

// Vérification du panier
if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    die("Erreur : Panier vide");
}

// Récupération des données
$nom_client = $_POST['nom'] ?? 'Non spécifié';
$adresse = $_POST['adresse'] ?? 'Non spécifiée';
$telephone = $_POST['telephone'] ?? 'Non spécifié';
$mode_paiement = $_POST['paiement'] ?? 'Non spécifié';
$total = $_POST['total'] ?? 0;

// Calcul des totaux
$frais_livraison = 1000;
$total_produits = 0;
$total_quantite = 0;

foreach ($_SESSION['panier'] as $item) {
    $total_produits += $item['prix'] * $item['quantite'];
    $total_quantite += $item['quantite'];
}

// Création du PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Couleur de texte pour meilleure lisibilité sur fond d'image
$pdf->SetTextColor(0, 0, 0); // Noir (ajustez selon votre fond)

// Informations du client dans un cadre
$pdf->SetFillColor(255, 255, 255, 80); // Fond semi-transparent
$pdf->Rect(10, 30, 190, 30, 'F');
$pdf->SetXY(15, 35);
$pdf->Cell(0, 7, 'Client : ' . $nom_client, 0, 1);
$pdf->Cell(0, 7, 'Adresse : ' . $adresse, 0, 1);
$pdf->Cell(0, 7, 'Telephone : ' . $telephone, 0, 1);
$pdf->Cell(0, 7, 'Paiement : ' . $mode_paiement, 0, 1);
$pdf->Ln(15);

// Tableau des produits avec fond semi-transparent
$pdf->SetFillColor(255, 255, 255, 80);
$pdf->Rect(10, $pdf->GetY(), 190, 10 + (count($_SESSION['panier']) * 10 + 30), 'F');

// En-tête du tableau
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(100, 10, 'Produit', 0, 0);
$pdf->Cell(30, 10, 'Quantite', 0, 0, 'R');
$pdf->Cell(30, 10, 'Prix unitaire', 0, 0, 'R');
$pdf->Cell(30, 10, 'Total', 0, 1, 'R');
$pdf->SetFont('Arial', '', 12);

// Ligne séparatrice
$pdf->Cell(190, 0, '', 'T');
$pdf->Ln(5);

// Contenu du panier
foreach ($_SESSION['panier'] as $item) {
    $pdf->Cell(100, 10, $item['nom'], 0, 0);
    $pdf->Cell(30, 10, $item['quantite'], 0, 0, 'R');
    $pdf->Cell(30, 10, number_format($item['prix'], 2) . ' fcfa', 0, 0, 'R');
    $pdf->Cell(30, 10, number_format($item['prix'] * $item['quantite'], 2) . ' fcfa', 0, 1, 'R');
}

// Totaux
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(160, 10, 'Total Produits:', 0, 0, 'R');
$pdf->Cell(30, 10, number_format($total_produits, 2) . ' fcfa', 0, 1, 'R');

$pdf->Cell(160, 10, 'Frais de livraison:', 0, 0, 'R');
$pdf->Cell(30, 10, number_format($frais_livraison, 2) . ' fcfa', 0, 1, 'R');

$pdf->Cell(160, 10, 'Total General:', 0, 0, 'R');
$pdf->Cell(30, 10, number_format($total_produits + $frais_livraison, 2) . ' fcfa', 0, 1, 'R');

// Date et signature
$pdf->Ln(20);
$pdf->Cell(0, 10, 'Fait a COTONOU, le ' . date('d/m/Y'), 0, 1);
$pdf->Cell(0, 10, 'Signature', 0, 1, 'R');

// Génération du PDF
$pdf->Output('D', 'Facture_' . date('Y-m-d') . '.pdf');