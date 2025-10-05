<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Omnes MarketPlace</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="/OmnesMarketPlace/assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="/OmnesMarketPlace/index.php">🛒 Omnes MarketPlace</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <?php $cartCount = !empty($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" href="/OmnesMarketPlace/pages/parcourir.php">Parcourir</a></li>
        <li class="nav-item"><a class="nav-link" href="/OmnesMarketPlace/pages/panier.php">Panier (<?= $cartCount; ?>)</a></li>

        <?php if (isset($_SESSION['user'])): ?>
          <?php if ($_SESSION['user']['role'] === 'vendor'): ?>
            <li class="nav-item"><a class="nav-link" href="/OmnesMarketPlace/vendor/produits.php">Vendeur</a></li>
            <li class="nav-item"><a class="nav-link" href="/OmnesMarketPlace/vendor/negociations.php">Négociations</a></li>
          <?php endif; ?>

          <?php if ($_SESSION['user']['role'] === 'admin'): ?>
            <li class="nav-item"><a class="nav-link" href="/OmnesMarketPlace/admin/dashboard.php">Admin</a></li>
            <li class="nav-item"><a class="nav-link" href="/OmnesMarketPlace/admin/auctions.php">Enchères</a></li>
          <?php endif; ?>

          <li class="nav-item"><a class="nav-link" href="/OmnesMarketPlace/pages/compte.php">Mon compte</a></li>
          <li class="nav-item"><a class="nav-link" href="/OmnesMarketPlace/pages/logout.php">Déconnexion</a></li>

        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="/OmnesMarketPlace/pages/login.php">Connexion</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
