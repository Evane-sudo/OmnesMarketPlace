<?php
include '../includes/header.php';
include '../includes/db.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
<?php if (!$product): ?>
  <div class="alert alert-warning">Produit introuvable.</div>
<?php else: ?>
  <div class="row">
    <div class="col-md-6">
      <img src="<?= htmlspecialchars($product['image_url']); ?>" class="img-fluid rounded shadow-sm" alt="">
    </div>

    <div class="col-md-6">
      <h2><?= htmlspecialchars($product['nom']); ?></h2>
      <p class="text-muted">Catégorie : <?= htmlspecialchars($product['categorie']); ?></p>
      <span class="badge bg-secondary mb-2"><?= htmlspecialchars($product['type_vente']); ?></span>
      <p class="lead fw-bold"><?= number_format($product['prix'], 2, ',', ' '); ?> €</p>
      <p><?= htmlspecialchars($product['description']); ?></p>

      <a href="panier.php?action=add&id=<?= $product['id']; ?>" class="btn btn-success mb-2">
        Ajouter au panier
      </a>

      <?php if ($product['type_vente'] === 'NEGOCIATION'): ?>
        <a href="negociation.php?item_id=<?= $product['id']; ?>" class="btn btn-warning">
          Négocier
        </a>
      <?php elseif ($product['type_vente'] === 'ENCHERE'): ?>
        <a href="enchere.php?item_id=<?= $product['id']; ?>" class="btn btn-danger">
          Enchérir (meilleure offre)
        </a>
      <?php endif; ?>
    </div>
  </div>
<?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
