<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $prenom = $_POST['prenom'];
  $nom = $_POST['nom'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $role = $_POST['role'] ?? 'buyer';

  // Vérifie si l'email existe déjà
  $check = $pdo->prepare("SELECT id FROM users WHERE email=?");
  $check->execute([$email]);
  if ($check->fetch()) {
    $message = "❌ Cet email est déjà utilisé.";
  } else {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (role, prenom, nom, email, password_hash) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$role, $prenom, $nom, $email, $hash]);
    $message = "✅ Compte créé avec succès ! Vous pouvez vous connecter.";
  }
}
?>
<div class="container mt-5">
  <h2>Créer un compte</h2>
  <?php if ($message): ?>
    <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label>Prénom</label>
      <input type="text" name="prenom" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Nom</label>
      <input type="text" name="nom" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Rôle</label>
      <select name="role" class="form-select">
        <option value="buyer">Acheteur</option>
        <option value="vendor">Vendeur</option>
      </select>
    </div>
    <div class="mb-3">
      <label>Mot de passe</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-success">Créer un compte</button>
    <a href="login.php" class="btn btn-link">Déjà inscrit ? Connexion</a>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
