<?php

session_start();
require_once('connexion.php');

// Si le panier est vide, redirection vers les produits
if (empty($_SESSION['panier'])) {
  header('Location: index.php?pg=produits');
  exit;
}

// Paramètres
$frais_livraison = 1000; // Exemple : 1000 fcfa
$total_general = 0;
$total_quantite = 0;

// Calcul du total avant affichage
foreach ($_SESSION['panier'] as $item) {
    $total_general += $item['prix'] * $item['quantite'];
    $total_quantite += $item['quantite'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de Commande</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    .container {
      max-width: 1000px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    h1, h2 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 20px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #ddd;
      text-align: left;
    }
    th {
      background: #f2f2f2;
    }
    .total-row {
      font-weight: bold;
      background-color: #f8f9fa;
    }
    form {
      margin-top: 30px;
    }
    label {
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
    }
    input, textarea, select {
      width: 100%;
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 4px;
      border: 1px solid #ccc;
    }
    .btn {
      display: inline-block;
      padding: 10px 20px;
      background-color: #2ecc71;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      border: none;
      cursor: pointer;
    }
    .btn:hover {
      background-color: #27ae60;
    }
  </style>
  <script>
    function afficherChampPaiement() {
      var modePaiement = document.getElementById("paiement").value;
      var champCarte = document.getElementById("champ-carte");
      var champMobile = document.getElementById("champ-mobile");
      
      champCarte.style.display = "none";
      champMobile.style.display = "none";
      
      if (modePaiement === "carte") {
        champCarte.style.display = "block";
      } else if (modePaiement === "mobile money") {
        champMobile.style.display = "block";
      }
    }
  </script>
</head>
<body>
  
<div class="container">
  <h1>Confirmation de Commande</h1>
  
  <h2>Recapitulatif</h2>
  <table>
    <thead>
      <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Prix Unitaire</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($_SESSION['panier'] as $item): ?>
      <tr>
        <td><?= htmlspecialchars($item['nom']) ?></td>
        <td><?= $item['quantite'] ?></td>
        <td><?= number_format($item['prix'], 2) ?> fcfa</td>
        <td><?= number_format($item['prix'] * $item['quantite'], 2) ?> fcfa</td>
      </tr>
      <?php endforeach; ?>
      <tr class="total-row">
        <td colspan="3">Nombre total de produits</td>
        <td><?= $total_quantite ?></td>
      </tr>
      <tr class="total-row">
        <td colspan="3">Total Produits</td>
        <td><?= number_format($total_general, 2) ?> fcfa</td>
      </tr>
      <tr class="total-row">
        <td colspan="3">Frais de livraison</td>
        <td><?= number_format($frais_livraison, 2) ?> fcfa</td>
      </tr>
      <tr class="total-row">
        <td colspan="3">Total à payer</td>
        <td><?= number_format($total_general + $frais_livraison, 2) ?> fcfa</td>
      </tr>
    </tbody>
  </table>

  <h2>Informations de Livraison</h2>
  <form action="valider_commande.php" method="post">
    <label for="nom">Nom complet</label>
    <input type="text" name="nom" id="nom" required>

    <label for="adresse">Adresse de livraison</label>
    <textarea name="adresse" id="adresse" rows="3" required></textarea>

    <label for="telephone">Téléphone</label>
    <input type="text" name="telephone" id="telephone" required>

    <label for="paiement">Mode de paiement</label>
    <select name="paiement" id="paiement" required onchange="afficherChampPaiement()">
      <option value="">-- Choisissez --</option>
      <option value="à la livraison">Paiement à la livraison</option>
      <option value="mobile money">Mobile Money</option>
      <option value="carte">Carte Bancaire</option>
    </select>
    
    <div id="champ-carte" style="display: none;">
      <label for="num_carte">Numéro de carte bancaire</label>
      <input type="text" name="num_carte" id="num_carte" placeholder="XXXX XXXX XXXX XXXX">
    </div>
    
    <div id="champ-mobile" style="display: none;">
      <label for="reseau_mobile">Réseau Mobile Money</label>
      <input type="text" name="reseau_mobile" id="reseau_mobile" placeholder="Orange, MTN, Moov...">
    </div>

    <input type="hidden" name="total" value="<?= $total_general + $frais_livraison ?>">

    <button type="submit" class="btn">Valider la Commande</button>
  </form>
</div>
</body>
</html>
<?php

// } //sinon on le redirige vers la page d'authentification
// elseif (empty($_SESSION['email'])) {
//   header('location:index.php?pg=connecte');
// }