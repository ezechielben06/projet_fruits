<?php
require_once('connexion.php');

// Vérifier si l'ID est présent dans l'URL
if (isset($_GET['id'])) {
  $id = intval($_GET['id']); // Sécuriser en convertissant en entier

  // Requête pour récupérer le produit spécifique
  $req = sprintf("SELECT * FROM produits WHERE id = %d", $id);
  $result = mysqli_query($conn, $req);
  $product = mysqli_fetch_assoc($result);

  if (!$product) {
    die("Produit non trouvé");
  }
} else {
  die("ID du produit non spécifié");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <title>Détails du produit - <?= htmlspecialchars($product['nom']); ?></title>
  <link rel="stylesheet" href="styles.css">
  <!-- Insérez ici vos balises meta et liens CSS -->
  <style>
    /* Styles pour la pop-up */
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: #fefefe;
      margin: 10% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 800px;
      border-radius: 8px;
      animation: modalopen 0.5s;
    }

    @keyframes modalopen {
      from {
        opacity: 0;
        transform: translateY(-50px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover {
      color: black;
    }

    .detail-container {
      display: flex;
      gap: 20px;
    }

    .detail-container img {
      max-width: 300px;
      max-height: 300px;
      object-fit: contain;
    }

    .info {
      flex: 1;
    }
  </style>
</head>

<body>
  <?php include("haut.php"); ?>

  <script>
    // Afficher la pop-up automatiquement au chargement de la page
    window.onload = function() {
      document.getElementById('productModal').style.display = 'block';
    };

    // Fermer la pop-up quand on clique sur la croix
    function closeModal() {
      document.getElementById('productModal').style.display = 'none';
      // Retour à la page précédente
      window.history.back();
    }

    // Fermer la pop-up quand on clique en dehors du contenu
    window.onclick = function(event) {
      const modal = document.getElementById('productModal');
      if (event.target == modal) {
        closeModal();
      }
    }
  </script>

  <!-- La pop-up (modal) -->
  <div id="productModal" class="modal">
    <div class="modal-content">
      <span class="close" onclick="closeModal()">&times;</span>
      <div class="product-grid">
        <h1 class="prod_aff"><?= htmlspecialchars($product['nom']); ?></h1>
        <div class="detail-container">
          <img src="<?= $product['photo']; ?>" alt="<?= htmlspecialchars($product['nom']); ?>">
          <div class="info">
            <!-- <?= $reduction = $product['prix'] * (1 - ($product['remise'] / 100)) . " fcfa"; ?> -->
            <p class="price">Prix: <?= $reduction; ?></p>
            <?php if ($product['remise'] > 0): ?>
              <p class="original-price">Ancien prix: <?php echo $product['prix'] . " fcfa"; ?></p>
              <p class="discount">Remise: <?= $product['remise']; ?>%</p>
              <?php echo "<style>
            .original-price {
              text-decoration: line-through #FF4500;
            }
          </style>" ?>
            <?php endif; ?>
            <p class="description"><?= nl2br(htmlspecialchars($product['detail'])); ?></p>
            <button class="btn"><i class="fas fa-cart-plus"></i><a href="panier.php?id=<?php echo $product['id'] ?>">Ajouter au Panier</a></button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include("products.php"); ?>
  <?php include("bas.php"); ?>
</body>

</html>