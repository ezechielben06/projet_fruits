<?php
require_once('connexion.php');

// Vérifier si un mot-clé a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['query'])) {
    $search = htmlspecialchars($_POST['query']);

    // Style CSS intégré
    echo '<style>
        .search-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
        }
        .search-results, .related-products {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
        }
        .section-title {
            color: #4CAF50;
            font-family: "Chewy", cursive;
            font-size: 28px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f7f7f7;
        }
        .results-grid, .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .product-card {
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s ease;
            background: #f7f7f7;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .product-link {
            text-decoration: none;
            color: #333;
            display: block;
        }
        .product-image {
            height: 180px;
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
        }
        .product-image img {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
        .product-info {
            padding: 15px;
        }
        .product-name {
            color: #4CAF50;
            font-weight: bold;
            margin: 0 0 5px 0;
            font-size: 16px;
        }
        .product-category {
            color: #FF6347;
            font-size: 14px;
            margin: 0 0 10px 0;
        }
        .product-price {
            font-weight: bold;
            color: #333;
        }
        .no-results {
            text-align: center;
            padding: 30px;
            color: #555;
        }
        .search-query {
            color: #FF6347;
            font-weight: bold;
        }
    </style>';

    echo '<div class="search-container">';

    // Recherche des produits correspondants
    $sql = "SELECT * FROM produits WHERE nom LIKE ? OR categorie LIKE ? ";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$search%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="search-results">';
    if ($result->num_rows > 0) {
        echo '<h2 class="section-title">Résultats pour "<span class="search-query">' . htmlspecialchars($search) . '</span>"</h2>';
        echo '<div class="results-grid">';

        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<a href="page-produit.php?id=' . urlencode($row['id']) . '" class="product-link">';
            echo '<div class="product-image">';
            // Remplacez par votre champ d'image si disponible
            echo '<a href="details-produit.php?id=' . $row['id'] . '">';
            echo '<img src="' . $row['photo'] . '" alt="' . htmlspecialchars($row['nom']) . '">';
            echo '</a>';
            echo '</div>';
            echo '<div class="product-info">';
            echo '<h3 class="product-name">' . htmlspecialchars($row['nom']) . '</h3>';
            echo '<p class="product-category">' . htmlspecialchars($row['categorie']) . '</p>';
            // Ajoutez le prix si disponible
            echo '<p class="product-price">' . number_format($row['prix'], 2, ',', ' ') . ' fcfa</p>';
            echo '</div>';
            echo '</a>';
            echo '</div>';

            // Stocker les catégories trouvées pour les suggestions
            $categories[] = $row['categorie'];
        }
        echo '</div>';
    } else {
        echo '<div class="no-results">';
        echo '<p>Aucun résultat trouvé pour "<span class="search-query">' . htmlspecialchars($search) . '</span>"</p>';
        echo '</div>';
    }
    echo '</div>';

    // Affichage des produits de mêmes catégories (si des résultats ont été trouvés)
    if (!empty($categories)) {
        // Prendre une catégorie au hasard parmi les résultats
        $randomCategory = $categories[array_rand($categories)];

        // Recherche d'autres produits de la même catégorie
        $sqlRelated = "SELECT * FROM produits WHERE categorie = ? AND (nom NOT LIKE ? OR nom NOT LIKE ?) ORDER BY RAND() LIMIT 4";
        $stmtRelated = $conn->prepare($sqlRelated);
        $stmtRelated->bind_param("sss", $randomCategory, $searchTerm, $searchTerm);
        $stmtRelated->execute();
        $resultRelated = $stmtRelated->get_result();

        if ($resultRelated->num_rows > 0) {
            echo '<div class="related-products">';
            echo '<h2 class="section-title">Vous aimerez aussi ces produits ' . strtolower($randomCategory) . '</h2>';
            echo '<div class="products-grid">';

            while ($rowRelated = $resultRelated->fetch_assoc()) {
                echo '<div class="product-card">';
                echo '<a href="details-produit.php?id=' . urlencode($rowRelated['id']) . '" class="product-link">';
                echo '<div class="product-image">';
                // Remplacez par votre champ d'image si disponible
                echo '<img src="' . $rowRelated['photo'] . '" alt="' . htmlspecialchars($rowRelated['nom']) . '">';
                echo '</div>';
                echo '<div class="product-info">';
                echo '<h3 class="product-name">' . htmlspecialchars($rowRelated['nom']) . '</h3>';
                echo '<p class="product-category">' . htmlspecialchars($rowRelated['categorie']) . '</p>';
                // Ajoutez le prix si disponible
                echo '<p class="product-price">' . number_format($rowRelated['prix'], 2, ',', ' ') . ' fcfa</p>';
                echo '</div>';
                echo '</a>';
                echo '</div>';
            }

            echo '</div>';
            echo '</div>';
        }
    }

    echo '</div>'; // Fermeture du search-container

    if (isset($stmt)) $stmt->close();
    if (isset($stmtRelated)) $stmtRelated->close();
}

$conn->close();
