<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'buyer') {
  echo "<div class='container mt-5'><div class='alert alert-warning'>Connectez-vous en tant qu'acheteur pour négocier.</div></div>";
  include '../includes/footer.php';
  exit;
}

$item_id = intval($_GET['item_id'] ?? 0);
$buyer_id = $_SESSION['user']['id'];

// Vérifier que l’article existe
$stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
$stmt->execute([$item_id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item) {
  echo "<div class='container mt-5'><div class='alert alert-danger'>Article introuvable.</div></div>";
  include '../includes/footer.php';
  exit;
}

// Vérifier s’il existe déjà une négociation
$stmt = $pdo->prepare("SELECT * FROM negotiations WHERE item_id=? AND buyer_id=?");
$stmt->execute([$item_id, $buyer_id]);
$nego = $stmt->fetch(PDO::FETCH_ASSOC);

// Créer une négociation si elle n’existe pas
if (!$nego) {
  $insert = $pdo->prepare("INSERT INTO negotiations (item_id, buyer_id, vendor_id) VALUES (?, ?, ?)");
  $insert->execute([$item_id, $buyer_id, $item['vendor_id']]);
  
  $stmt = $pdo->prepare("SELECT * FROM negotiations WHERE item_id=? AND buyer_id=?");
  $stmt->execute([$item_id, $buyer_id]);
  $nego = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Enregistrer une offre
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prix'])) {
  if ($nego && $nego['tour_count'] < 5 && $nego['statut'] === 'EN_COURS') {
    $prix = floatval($_POST['prix']);
    $pdo->prepare("INSERT INTO negotiation_offers (negotiation_id, emetteur, prix_propose) VALUES (?, 'BUYER', ?)")
        ->execute([$nego['id'], $prix]);
    $pdo->prepare("UPDATE negotiations SET tour_count = tour_count + 1 WHERE id=?")->execute([$nego['id']]);
    header("Location: negociation.php?item_id=$item_id");
    exit;
  }
}

// Récupérer l’historique des offres
$offers = [];
if ($nego) {
  $stmt = $pdo->prepare("SELECT * FROM negotiation_offers WHERE negotiation_id=? ORDER BY created_at ASC");
  $stmt->execute([$nego['id']]);
  $offers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<div class="container mt-5">
  <h2>Négociation – <?= htmlspecialchars($item['nom']); ?></h2>
  <p>Prix affiché : <strong><?= number_format($item['prix'], 2, ',', ' '); ?> €</strong></p>

  <p>Statut :
    <?php if ($nego): ?>
      <span class="badge bg-secondary"><?= htmlspecialchars($nego['statut']); ?></span>
    <?php else: ?>
      <span class="badge bg-warning text-dark">Non commencée</span>
    <?php endif; ?>
  </p>

  <h5>Historique des offres :</h5>
  <?php if ($offers): ?>
    <ul class="list-group mb-3">
      <?php foreach ($offers as $o): ?>
        <li class="list-group-item">
          <strong><?= $o['emetteur'] === 'BUYER' ? 'Acheteur' : 'Vendeur'; ?> :</strong>
          <?= number_format($o['prix_propose'], 2, ',', ' '); ?> €
          <span class="text-muted float-end"><?= $o['created_at']; ?></span>
        </li>
      <?php endforeach; ?>
    </ul>
  <?php else: ?>
    <p>Aucune offre pour l’instant.</p>
  <?php endif; ?>

  <?php if ($nego && $nego['statut'] === 'EN_COURS' && $nego['tour_count'] < 5): ?>
    <form method="post" class="d-flex gap-2">
      <input type="number" step="0.01" name="prix" class="form-control" placeholder="Votre offre (€)" required>
      <button class="btn btn-primary">Proposer</button>
    </form>
  <?php else: ?>
    <div class="alert alert-secondary mt-2">
      Nombre de tours maximum atteint (5) ou négociation close.
    </div>
  <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
