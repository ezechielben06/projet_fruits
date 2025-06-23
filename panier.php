<?php
session_start();
require_once('connexion.php'); // Connexion à la base de données

if (!isset($_SESSION['panier'])) {
  $_SESSION['panier'] = [];
}

// Ajouter un produit au panier
if (isset($_GET['id']) && !isset($_GET['action'])) { // Éviter d'exécuter cette partie quand on change la quantité
  $id_produit = intval($_GET['id']);

  // Vérifier si le produit est déjà dans le panier
  $trouve = false;
  foreach ($_SESSION['panier'] as &$item) {
    if ($item['id'] == $id_produit) {
      $item['quantite'] += 1;
      $trouve = true;
      break;
    }
  }
  unset($item); // Sécurisation pour éviter des erreurs de référence

  // Si le produit n'est pas encore dans le panier, l'ajouter
  if (!$trouve) {
    $req = "SELECT * FROM produits WHERE id = $id_produit";
    $result = mysqli_query($conn, $req);
    $produit = mysqli_fetch_assoc($result);

    if ($produit) {
      $produit['quantite'] = 1;
      $_SESSION['panier'][] = $produit;
    }
  }
}

// Gérer l'augmentation ou la diminution de la quantité
if (isset($_GET['action']) && isset($_GET['id'])) {
  $id_modif = intval($_GET['id']);

  foreach ($_SESSION['panier'] as &$item) {
    if ($item['id'] == $id_modif) {
      if ($_GET['action'] == 'plus') {
        $item['quantite'] += 1;
      } elseif ($_GET['action'] == 'moins' && $item['quantite'] > 1) {
        $item['quantite'] -= 1;
      }
      break;
    }
  }
  unset($item);
}

// Supprimer un produit du panier
if (isset($_GET['delete'])) {
  $id_delete = intval($_GET['delete']);
  foreach ($_SESSION['panier'] as $key => $item) {
    if ($item['id'] == $id_delete) {
      unset($_SESSION['panier'][$key]);
      $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexation
      break;
    }
  }
}

// Vider le panier
if (isset($_GET['clear'])) {
  unset($_SESSION['panier']);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="styles.css">
  <title>Panier</title>
  <style>
    .container {
      max-width: 1000px;
      margin: 30px auto;
      background: white;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
      color: #2c3e50;
      text-align: center;
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 1px solid #eee;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    th,
    td {
      padding: 12px 15px;
      text-align: left;
      border-bottom: 1px solid #ddd;
      vertical-align: middle;
    }

    th {
      background-color: #f2f2f2;
      font-weight: 600;
      color: #444;
    }

    tr:hover {
      background-color: #f9f9f9;
    }

    .product-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 4px;
      border: 1px solid #eee;
    }

    .btn {
      display: inline-block;
      padding: 8px 16px;
      background-color: #3498db;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      margin-right: 8px;
      transition: all 0.3s ease;
      font-size: 14px;
      border: none;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #2980b9;
      transform: translateY(-1px);
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-danger {
      background-color: #e74c3c;
    }

    .btn-danger:hover {
      background-color: #c0392b;
    }

    .btn-success {
      background-color: #2ecc71;
    }

    .btn-success:hover {
      background-color: #27ae60;
    }

    .btn-group {
      margin-top: 30px;
      text-align: center;
    }

    .empty-cart {
      text-align: center;
      padding: 40px 0;
    }

    .empty-cart p {
      font-size: 18px;
      color: #7f8c8d;
      margin-bottom: 20px;
    }

    .quantity-control {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .quantity-control a {
      display: inline-block;
      width: 28px;
      height: 28px;
      line-height: 28px;
      text-align: center;
      background-color: #f2f2f2;
      border-radius: 50%;
      font-weight: bold;
      color: #333;
      text-decoration: none;
      transition: all 0.2s;
    }

    .quantity-control a:hover {
      background-color: #e0e0e0;
      color: #000;
    }

    .total-row {
      font-weight: bold;
      background-color: #f8f9fa;
    }

    .text-right {
      text-align: right;
    }

    @media (max-width: 768px) {
      .container {
        padding: 15px;
      }

      table {
        font-size: 14px;
      }

      th,
      td {
        padding: 8px 10px;
      }

      .product-img {
        width: 60px;
        height: 60px;
      }
    }
  </style>
</head>

<body>
  <?php include("haut.php"); ?>
  <div class="container">
    <h1>Votre Panier</h1>

    <?php if (!empty($_SESSION['panier'])) { ?>
      <table>
        <thead>
          <tr>
            <th>Image</th>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Prix Unitaire</th>
            <th>Quantité</th>
            <th>Total</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $total_general = 0;
          foreach ($_SESSION['panier'] as $item) {
            $total = $item['prix'] * $item['quantite'];
            $total_general += $total;
          ?>
            <tr>
              <td>
                <img src="<?= htmlspecialchars($item['photo'] ?? 'images/default-product.jpg') ?>"
                  alt="<?= htmlspecialchars($item['nom']) ?>"
                  class="product-img">
              </td>
              <td><?= htmlspecialchars($item['nom']); ?></td>
              <td><?= htmlspecialchars($item['categorie']); ?></td>
              <td><?= number_format($item['prix'], 2); ?> fcfa</td>
              <td>
                <div class="quantity-control">
                  <a href="panier.php?action=moins&id=<?= $item['id']; ?>">-</a>
                  <?= $item['quantite']; ?>
                  <a href="panier.php?action=plus&id=<?= $item['id']; ?>">+</a>
                </div>
              </td>
              <td><?= number_format($total, 2); ?> fcfa</td>
              <td>
                <a href="panier.php?delete=<?= $item['id']; ?>" class="btn btn-danger">Supprimer</a>
              </td>
            </tr>
          <?php } ?>
          <tr class="total-row">
            <td colspan="4" class="text-right"><strong>Total Général :</strong></td>
            <td><strong><?= array_sum(array_column($_SESSION['panier'], 'quantite')); ?></strong></td>
            <td><strong><?= number_format($total_general, 2); ?> fcfa</strong></td>
            <td></td>
          </tr>
        </tbody>
      </table>

      <div class="btn-group">
        <a href="index.php?pg=produits" class="btn">Continuer mes achats</a>
        <a href="panier.php?clear=1" class="btn btn-danger">Vider le Panier</a>
        <a href="index.php?pg=connecte" class="btn btn-success">Passer la Commande</a>
      </div>
    <?php } else { ?>
      <div class="empty-cart">
        <p>Votre panier est vide.</p>
        <a href="index.php?pg=produits" class="btn">Retour à la boutique</a>
      </div>
    <?php } ?>
  </div>
  <?php include("bas.php"); ?>
</body>

</html>