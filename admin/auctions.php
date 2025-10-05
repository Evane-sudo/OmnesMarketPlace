<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  echo "<div class='container mt-5'><div class='alert alert-danger'>Accès réservé à l’administrateur.</div></div>";
  include '../includes/footer.php';
  exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $item_id = intval($_POST['item_id']);
  $start = $_POST['start'];
  $end = $_POST['end'];

  $pdo->prepare("INSERT INTO auctions (item_id, debut_at, fin_at)
                 VALUES (?, ?, ?)
                 ON DUPLICATE KEY UPDATE debut_at=VALUES(debut_at), fin_at=VALUES(fin_at)")
      ->execute([$item_id, $start, $end]);

  $pdo->prepare("UPDATE items SET type_vente='ENCHERE' WHERE id=?")->execute([$item_id]);
  $message = "✅ Enchère configurée avec succès.";
}

$items = $pdo->query("SELECT id, nom FROM items ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$auctions = $pdo->query("SELECT a.*, i.nom FROM auctions a JOIN items i ON a.item_id=i.id ORDER BY a.debut_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <h2>Gestion des enchères (Admin)</h2>
  <?php if ($message): ?><div class="alert alert-success"><?= htmlspecialchars($message); ?></div><?php endif; ?>

  <form method="post" class="row g-2 mb-4">
    <div class="col-md-4">
      <select name="item_id" class="form-select" required>
        <option value="">Choisir un article</option>
        <?php foreach ($items as $it): ?>
          <option value="<?= $it['id']; ?>"><?= htmlspecialchars($it['nom']); ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3"><input type="datetime-local" name="start" class="form-control" required></div>
    <div class="col-md-3"><input type="datetime-local" name="end" class="form-control" required></div>
    <div class="col-md-2 d-grid"><button class="btn btn-primary">Enregistrer</button></div>
  </form>

  <table class="table table-striped">
    <thead><tr><th>Article</th><th>Début</th><th>Fin</th></tr></thead>
    <tbody>
      <?php foreach ($auctions as $a): ?>
        <tr>
          <td><?= htmlspecialchars($a['nom']); ?></td>
          <td><?= htmlspecialchars($a['debut_at']); ?></td>
          <td><?= htmlspecialchars($a['fin_at']); ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$auctions): ?><tr><td colspan="3">Aucune enchère configurée.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
