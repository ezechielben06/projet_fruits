<main>

  <!-- Connexion Section -->
  <section class="connexion">
    <h2> inscrivez vous ou connectez vous pour pouvoir passer la commande</h2>
    <div class="connexion-container">
      <!-- Toggle Buttons -->
      <div class="toggle-buttons">
        <button id="login-toggle" class="active">Connexion</button>
        <button id="register-toggle">Inscription</button>
      </div>

      <!-- Login Form -->
      <form action="authent.php" method="post" id="login-form" class="form active">
        <label for="email">Email</label>
        <input type="email" id="email" required name="email">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" required name="password">
        <button type="submit"><i class="fas fa-sign-in-alt" name="login"></i> Se Connecter</button>
      </form>

      <!-- Registration Form -->
      <form action="index.php?pg=send" method="post" id="register-form" class="form ">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
        <button type="submit"><i class="fas fa-user-plus" name="inscrit"></i> S'inscrire</button>
      </form>
    </div>
  </section>
</main>
<script src="script.js"></script>