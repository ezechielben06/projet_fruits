<main>
  <section class="banner">
    <div class="banner-content">
      <h2>Offre Spéciale !</h2>
      <p>Profitez de nos fruits frais à des prix incroyables. Offre valable jusqu'au 28 avril 2025.</p>
      <a href="#prd" class="btn"><i class="fas fa-shopping-basket"></i> Acheter Maintenant</a>
    </div>
  </section>
  <!-- Liste des produits -->
  <?php require_once('connexion.php');
  $req = sprintf("Select * from produits ",);
  $result = mysqli_query($conn, $req);

  ?>
  <section id="prd" class="products">
    <h2>Tous les Produits</h2>
    <div class="product-grid">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="product-card">
          <a href="details-produit.php?id=<?= $row['id']; ?>">
            <img src="<?= $row['photo']; ?>" alt="<?= htmlspecialchars($row['nom']); ?>">
          </a>
          <h3><?= $row['nom']; ?></h3>
          <!-- <?= $original = $row['prix'] * (1 - ($row['remise'] / 100)) . " fcfa"; ?> -->
          <p class="price"><?= $original; ?></p>
          <p class="original-price"><?php echo $row['prix'] . " fcfa"; ?></p>
          <p class="discount"><?= "remise:" . $row['remise'] . "%"; ?></p>
          <?php echo "<style>
            .original-price {
              text-decoration: line-through #FF4500;
            }
          </style>" ?>
          <button class="btn"><i class="fas fa-cart-plus"></i><a href="panier.php?id=<?php echo $row['id'] ?>">Ajouter au Panier</a></button>
        </div>
      <?php } ?>
    </div>
  </section>
</main>