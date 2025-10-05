<?php
session_start();
include '../includes/header.php';

if (!isset($_SESSION['user'])) {
  echo "<div class='container mt-5'><div class='alert alert-warning'>Veuillez vous connecter pour accéder à votre compte.</div></div>";
  include '../includes/footer.php';
  exit;
}

$user = $_SESSION['user'];
?>

<div class="container mt-5">
  <h2>Mon compte</h2>
  <div class="card shadow-sm p-4">
    <h4 class="mb-3"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?></h4>
    <p><strong>Email :</strong> <?= htmlspecialchars($user['email']); ?></p>
    <p><strong>Rôle :</strong> 
      <?php if ($user['role'] === 'admin'): ?>
        <span class="badge bg-danger">Administrateur</span>
      <?php elseif ($user['role'] === 'vendor'): ?>
        <span class="badge bg-warning text-dark">Vendeur</span>
      <?php else: ?>
        <span class="badge bg-primary">Acheteur</span>
      <?php endif; ?>
    </p>

    <hr>
    <a href="logout.php" class="btn btn-outline-danger">Se déconnecter</a>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
