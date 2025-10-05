<?php
session_start();
include '../includes/header.php';
include '../includes/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $numero = str_replace(' ', '', $_POST['numero']);
  $exp = $_POST['exp'];
  $cvc = $_POST['cvc'];

  $stmt = $pdo->prepare("SELECT * FROM payments WHERE numero=? AND exp=? AND cvc=?");
  $stmt->execute([$numero, $exp, $cvc]);
  $valid = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($valid) {
    $message = "✅ Paiement accepté ! Merci pour votre achat.";
    $_SESSION['cart'] = []; // Vider le panier
  } else {
    $message = "❌ Paiement refusé. Vérifiez vos informations.";
  }
}
?>

<div class="container mt-5">
  <h2>Paiement</h2>
  <?php if ($message): ?>
    <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <form method="post" class="row g-3">
    <div class="col-md-6">
      <label>Numéro de carte</label>
      <input type="text" name="numero" class="form-control" placeholder="4111 1111 1111 1111" required>
    </div>
    <div class="col-md-3">
      <label>Date d’expiration</label>
      <input type="text" name="exp" class="form-control" placeholder="MM/AA" required>
    </div>
    <div class="col-md-3">
      <label>CVC</label>
      <input type="text" name="cvc" class="form-control" placeholder="123" required>
    </div>
    <div class="col-12">
      <button class="btn btn-success">Payer maintenant</button>
    </div>
  </form>

  <p class="text-muted mt-3">Carte de test : <b>4111 1111 1111 1111</b> — Exp <b>12/27</b> — CVC <b>123</b></p>
</div>

<?php include '../includes/footer.php'; ?>
