<?php include 'includes/header.php'; ?>

<!-- Section d’accueil principale -->
<section class="hero-section text-center text-light" 
         style="background: linear-gradient(120deg, #002855, #00509e);
                padding: 90px 20px; 
                border-bottom-left-radius: 40px; 
                border-bottom-right-radius: 40px;">
  <div class="container">
    <h1 class="display-4 fw-bold mb-3">
      Bienvenue sur <span style="color:#ffc107;">Omnes MarketPlace</span> 🛍️
    </h1>
    <p class="lead mb-4">
      La plateforme e-commerce développée par les étudiants de l’ECE Paris<br>
      Achetez, négociez ou enché­rissez selon vos envies !
    </p>
    <a href="pages/parcourir.php" class="btn btn-warning btn-lg shadow">Découvrir les produits</a>
  </div>
</section>

<!-- Section d’intro : les trois modes d’achat -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-4">🧩 Trois modes d'achat</h2>
    <div class="row g-4 justify-content-center">
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h5 class="fw-bold text-primary">Achat immédiat</h5>
            <p>Commandez vos articles en un clic et profitez d’une livraison rapide.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h5 class="fw-bold text-warning">Transaction vendeur-client</h5>
            <p>Négociez jusqu’à 5 fois avec le vendeur pour obtenir le meilleur prix.</p>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body">
            <h5 class="fw-bold text-danger">Meilleure offre (enchères)</h5>
            <p>Participez à des enchères automatiques sur des articles rares !</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Section Campus ECE -->
<section class="py-5 text-center" style="background-color: #f0f3f7;">
  <div class="container">
    <h2 class="fw-bold mb-4">🏫 ECE Paris – Campus de la Tour Eiffel</h2>
    <p class="mb-4">
      Située au cœur de Paris, l’ECE forme les ingénieurs du numérique : innovation, cybersécurité, cloud, data et IA.
    </p>
    <div class="ratio ratio-16x9 mx-auto" style="max-width:800px;">
      <iframe src="https://maps.google.com/maps?q=ECE%20Paris&t=&z=15&ie=UTF8&iwloc=&output=embed" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
