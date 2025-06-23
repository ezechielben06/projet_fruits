<main>
  <!-- Hero Section -->
  <section class="hero">
    <h1>Bienvenue chez Greenshop</h1>
    <p>Votre destination pour des fruits et légumes frais et délicieux !</p>
    <a href="index.php?pg=produits" class="btn"><i class="fas fa-shopping-basket"></i> Acheter Maintenant</a>
  </section>
  <?php require_once('connexion.php');
  $req = sprintf("SELECT * FROM produits ORDER BY RAND() limit 5",);
  $result = mysqli_query($conn, $req);

  ?>
  <!-- Produits en vedette -->
  <section id="prd" class="products">
    <h2>Produits en vedette</h2>
    <div class="product-grid">
      <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <div class="product-card">
          <a href="details-produit.php?id=<?= $row['id']; ?>">
            <img src="<?= $row['photo'] ?>" alt="<?= htmlspecialchars($row['nom']); ?>">
          </a>
          <h3><?= $row['nom']; ?></h3>
          <!-- <?= $reduction = $row['prix'] * (1 - ($row['remise'] / 100)) . " fcfa"; ?> -->
          <p class="price"><?= $reduction; ?></p>
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