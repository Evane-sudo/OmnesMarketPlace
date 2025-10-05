<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
  $stmt->execute([$email]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user'] = $user;
    header('Location: ../index.php');
    exit;
  } else {
    $message = "Identifiants incorrects.";
  }
}
?>
<div class="container mt-5">
  <h2>Connexion</h2>
  <?php if ($message): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <form method="post">
    <div class="mb-3">
      <label>Email</label>
      <input type="email" name="email" class="form-control" required>
    </div>
    <div class="mb-3">
      <label>Mot de passe</label>
      <input type="password" name="password" class="form-control" required>
    </div>
    <button class="btn btn-primary">Se connecter</button>
    <a href="register.php" class="btn btn-link">Créer un compte</a>
  </form>
</div>

<?php include '../includes/footer.php'; ?>
