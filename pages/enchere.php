<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'buyer') {
  echo "<div class='container mt-5'><div class='alert alert-warning'>Connectez-vous en tant qu'acheteur pour enchérir.</div></div>";
  include '../includes/footer.php';
  exit;
}

$item_id = intval($_GET['item_id'] ?? 0);
$stmt = $pdo->prepare("SELECT i.*, a.id AS auction_id, a.debut_at, a.fin_at
                       FROM items i JOIN auctions a ON a.item_id=i.id WHERE i.id=?");
$stmt->execute([$item_id]);
$data = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$data) {
  echo "<div class='container mt-5'><div class='alert alert-warning'>Aucune enchère pour cet article.</div></div>";
  include '../includes/footer.php';
  exit;
}

$auction_id = $data['auction_id'];
$start = strtotime($data['debut_at']);
$end = strtotime($data['fin_at']);
$now = time();
$buyer_id = $_SESSION['user']['id'];
$message = '';

// Enregistrer l'offre max
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['max_offer'])) {
  if ($now < $start || $now > $end) {
    $message = "Enchère hors période.";
  } else {
    $max = floatval($_POST['max_offer']);
    $pdo->prepare("INSERT INTO bids (auction_id, buyer_id, max_offer) VALUES (?, ?, ?)")
        ->execute([$auction_id, $buyer_id, $max]);
    $message = "✅ Votre meilleure offre a été enregistrée.";
  }
}

// Calcul du prix courant
$maxes = $pdo->prepare("SELECT max_offer FROM bids WHERE auction_id=? ORDER BY max_offer DESC");
$maxes->execute([$auction_id]);
$arr = $maxes->fetchAll(PDO::FETCH_COLUMN);

$startPrice = $data['prix'];
$current = $startPrice;

if ($arr) {
  $max1 = floatval($arr[0]);
  if (count($arr) === 1) {
    $current = $startPrice;
  } else {
    $max2 = floatval($arr[1]);
    $current = max($startPrice, min($max1, $max2 + 1));
  }
}

$winnerText = '';
if ($now > $end && $arr) {
  $w = $pdo->prepare("SELECT buyer_id, max_offer FROM bids WHERE auction_id=? ORDER BY max_offer DESC, created_at ASC LIMIT 1");
  $w->execute([$auction_id]);
  $winfo = $w->fetch(PDO::FETCH_ASSOC);
  $winnerText = "🏆 Vainqueur : Acheteur #" . $winfo['buyer_id'] . " — Prix final : " . number_format($current, 2, ',', ' ') . " €";
}
?>
<div class="container mt-5">
  <h2>Enchère – <?= htmlspecialchars($data['nom']); ?></h2>
  <p>Période : <?= htmlspecialchars($data['debut_at']); ?> → <?= htmlspecialchars($data['fin_at']); ?></p>
  <p><strong>Prix actuel :</strong> <?= number_format($current, 2, ',', ' '); ?> €</p>
  <?php if ($message): ?><div class="alert alert-info"><?= htmlspecialchars($message); ?></div><?php endif; ?>

  <?php if ($now < $end): ?>
    <form method="post" class="row g-2">
      <div class="col-md-6">
        <label>Votre meilleure offre (€)</label>
        <input type="number" step="0.01" name="max_offer" class="form-control" required>
      </div>
      <div class="col-md-2 d-grid align-end">
        <button class="btn btn-danger mt-4">Enregistrer</button>
      </div>
    </form>
    <p class="text-muted mt-2">Le système surenchérira automatiquement jusqu’à votre maximum.</p>
  <?php else: ?>
    <div class="alert alert-secondary">⏰ Enchère terminée.</div>
    <?php if ($winnerText): ?><div class="alert alert-success"><?= $winnerText; ?></div><?php endif; ?>
  <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
