<header>
    <nav>
        <div class="logo">Greenshop</div>
        <ul class="nav-links">
            <li><a href="index.php?pg=acceuil"><i class="fas fa-home"></i> Accueil</a></li>
            <li><a href="index.php?pg=produits"><i class="fas fa-shopping-basket"></i> Produits</a></li>
            <li><a href="index.php?pg=auteur"><i class="fas fa-user"></i> Auteurs</a></li>
            <li><a href="panier.php"><i class="fas fa-shopping-cart"></i> Panier</a></li>
            <li><a href="index.php?pg=connecte" id="login-btn"><i class="fas fa-sign-in-alt"></i> Connexion</a></li>
        </ul>
        <form action="index.php?pg=recherche" method="post">
            <div class="search-bar">
                <input name="query" type="text" id="search-input" placeholder="Rechercher des produits...">
                <button id="search-btn"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </nav>
</header>