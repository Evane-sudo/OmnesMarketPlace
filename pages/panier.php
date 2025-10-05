<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// ➕ Ajouter un produit au panier
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  if (!in_array($id, $_SESSION['cart'])) {
    $_SESSION['cart'][] = $id;
  }
  header('Location: panier.php');
  exit;
}

// ➖ Supprimer un produit du panier
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
  $id = intval($_GET['id']);
  $_SESSION['cart'] = array_values(array_filter($_SESSION['cart'], fn($x) => $x !== $id));
  header('Location: panier.php');
  exit;
}

// Charger les produits du panier
$items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
  $ids = implode(',', array_map('intval', $_SESSION['cart']));
  $stmt = $pdo->query("SELECT * FROM items WHERE id IN ($ids)");
  $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
  foreach ($items as $it) {
    $total += $it['prix'];
  }
}
?>
<div class="container mt-5">
  <h2>Votre panier</h2>
  <?php if (!$items): ?>
    <p>Votre panier est vide.</p>
  <?php else: ?>
    <ul class="list-group mb-3">
      <?php foreach ($items as $it): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <span><?= htmlspecialchars($it['nom']); ?></span>
          <div>
            <span class="me-3"><?= number_format($it['prix'], 2, ',', ' '); ?> €</span>
            <a class="btn btn-sm btn-outline-danger" href="panier.php?action=remove&id=<?= $it['id']; ?>">Retirer</a>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
    <div class="d-flex justify-content-between">
      <strong>Total</strong>
      <strong><?= number_format($total, 2, ',', ' '); ?> €</strong>
    </div>
    <a class="btn btn-primary mt-3" href="checkout.php">Passer à la commande</a>
  <?php endif; ?>
</div>
<?php include '../includes/footer.php'; ?>
