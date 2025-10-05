<?php
include '../includes/header.php';
include '../includes/db.php';

$cat = $_GET['cat'] ?? '';
$q = trim($_GET['q'] ?? '');

// Récupération des catégories
$cats = $pdo->query("SELECT DISTINCT COALESCE(categorie,'Autre') AS c FROM items ORDER BY c")
             ->fetchAll(PDO::FETCH_COLUMN);

// Construction de la requête principale
$sql = "SELECT * FROM items WHERE statut='EN_VENTE'";
$params = [];

if ($cat !== '') {
  $sql .= " AND categorie=?";
  $params[] = $cat;
}

if ($q !== '') {
  $sql .= " AND (nom LIKE ? OR description LIKE ?)";
  $params[] = "%$q%";
  $params[] = "%$q%";
}

$sql .= " ORDER BY created_at DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <h2 class="mb-4">Tout parcourir</h2>

  <form class="row g-2 mb-4" method="get">
    <div class="col-md-4">
      <select name="cat" class="form-select">
        <option value="">Toutes les catégories</option>
        <?php foreach ($cats as $c): ?>
          <option value="<?= htmlspecialchars($c); ?>" <?= ($cat===$c)?'selected':''; ?>>
            <?= htmlspecialchars($c); ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="col-md-6">
      <input type="text" name="q" class="form-control" placeholder="Rechercher..." 
             value="<?= htmlspecialchars($q); ?>">
    </div>

    <div class="col-md-2 d-grid">
      <button class="btn btn-outline-primary">Filtrer</button>
    </div>
  </form>

  <div class="row g-3">
    <?php foreach ($products as $p): ?>
      <div class="col-sm-6 col-md-4">
        <div class="card h-100 shadow-sm">
          <img src="<?= htmlspecialchars($p['image_url']); ?>" class="card-img-top" alt="">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title"><?= htmlspecialchars($p['nom']); ?></h5>
            <p class="small text-muted mb-1">Catégorie : <?= htmlspecialchars($p['categorie']); ?></p>
            <span class="badge bg-secondary mb-2"><?= htmlspecialchars($p['type_vente']); ?></span>
            <p class="fw-bold mb-3"><?= number_format($p['prix'], 2, ',', ' '); ?> €</p>
            <a class="btn btn-outline-primary mt-auto" href="produit.php?id=<?= $p['id']; ?>">Voir</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

    <?php if (!$products): ?>
      <p>Aucun produit trouvé.</p>
    <?php endif; ?>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
