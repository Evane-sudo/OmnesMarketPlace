<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
  echo "<div class='container mt-5'><div class='alert alert-danger'>Accès réservé à l’administrateur.</div></div>";
  include '../includes/footer.php';
  exit;
}

// Supprimer un vendeur
if (isset($_GET['delete_vendor'])) {
  $id = intval($_GET['delete_vendor']);
  $pdo->prepare("DELETE FROM users WHERE id=? AND role='vendor'")->execute([$id]);
  echo "<script>alert('Vendeur supprimé.'); window.location='dashboard.php';</script>";
  exit;
}

// Ajouter un vendeur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_vendor'])) {
  $prenom = $_POST['prenom'];
  $nom = $_POST['nom'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $pdo->prepare("INSERT INTO users (role, prenom, nom, email, password_hash) VALUES ('vendor', ?, ?, ?, ?)");
  $stmt->execute([$prenom, $nom, $email, $password]);
  echo "<script>alert('Nouveau vendeur ajouté !'); window.location='dashboard.php';</script>";
  exit;
}

// Récupérer vendeurs et acheteurs
$vendors = $pdo->query("SELECT * FROM users WHERE role='vendor' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
$buyers = $pdo->query("SELECT * FROM users WHERE role='buyer' ORDER BY created_at DESC")->fetchAll(PDO::FETCH_ASSOC);

// Récupérer produits
$items = $pdo->query("SELECT i.*, u.prenom, u.nom FROM items i LEFT JOIN users u ON i.vendor_id=u.id ORDER BY i.created_at DESC")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container mt-5">
  <h2>Tableau de bord Administrateur</h2>

  <div class="card p-4 mb-5 shadow-sm">
    <h4>Ajouter un vendeur</h4>
    <form method="post" class="row g-2">
      <input type="hidden" name="add_vendor" value="1">
      <div class="col-md-3"><input type="text" name="prenom" class="form-control" placeholder="Prénom" required></div>
      <div class="col-md-3"><input type="text" name="nom" class="form-control" placeholder="Nom" required></div>
      <div class="col-md-3"><input type="email" name="email" class="form-control" placeholder="Email" required></div>
      <div class="col-md-3"><input type="password" name="password" class="form-control" placeholder="Mot de passe" required></div>
      <div class="col-md-12 d-grid"><button class="btn btn-primary mt-2">Ajouter</button></div>
    </form>
  </div>

  <h4>Liste des vendeurs</h4>
  <table class="table table-striped mb-5">
    <thead><tr><th>ID</th><th>Nom</th><th>Email</th><th>Action</th></tr></thead>
    <tbody>
      <?php foreach ($vendors as $v): ?>
        <tr>
          <td><?= $v['id']; ?></td>
          <td><?= htmlspecialchars($v['prenom'].' '.$v['nom']); ?></td>
          <td><?= htmlspecialchars($v['email']); ?></td>
          <td><a href="?delete_vendor=<?= $v['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer ce vendeur ?')">Supprimer</a></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$vendors): ?><tr><td colspan="4">Aucun vendeur pour le moment.</td></tr><?php endif; ?>
    </tbody>
  </table>

  <h4>Liste des acheteurs</h4>
  <table class="table table-bordered mb-5">
    <thead><tr><th>ID</th><th>Nom</th><th>Email</th></tr></thead>
    <tbody>
      <?php foreach ($buyers as $b): ?>
        <tr>
          <td><?= $b['id']; ?></td>
          <td><?= htmlspecialchars($b['prenom'].' '.$b['nom']); ?></td>
          <td><?= htmlspecialchars($b['email']); ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$buyers): ?><tr><td colspan="3">Aucun acheteur trouvé.</td></tr><?php endif; ?>
    </tbody>
  </table>

  <h4>Produits disponibles</h4>
  <table class="table table-hover">
    <thead><tr><th>ID</th><th>Nom</th><th>Vendeur</th><th>Prix (€)</th><th>Type</th><th>Statut</th></tr></thead>
    <tbody>
      <?php foreach ($items as $i): ?>
        <tr>
          <td><?= $i['id']; ?></td>
          <td><?= htmlspecialchars($i['nom']); ?></td>
          <td><?= htmlspecialchars($i['prenom'].' '.$i['nom']); ?></td>
          <td><?= number_format($i['prix'], 2, ',', ' '); ?></td>
          <td><?= htmlspecialchars($i['type_vente']); ?></td>
          <td><?= htmlspecialchars($i['statut']); ?></td>
        </tr>
      <?php endforeach; ?>
      <?php if (!$items): ?><tr><td colspan="6">Aucun produit trouvé.</td></tr><?php endif; ?>
    </tbody>
  </table>
</div>

<?php include '../includes/footer.php'; ?>
