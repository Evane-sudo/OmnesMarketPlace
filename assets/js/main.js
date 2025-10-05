/* =============================
   Omnes MarketPlace - main.js
   ============================= */

// Message de confirmation lors de l'ajout au panier
document.addEventListener('DOMContentLoaded', () => {
  const url = new URL(window.location.href);
  if (url.searchParams.get('action') === 'add') {
    alert('✅ Produit ajouté au panier avec succès !');
  }
});

// Animation légère des boutons
const buttons = document.querySelectorAll('.btn');
buttons.forEach(btn => {
  btn.addEventListener('mouseenter', () => {
    btn.style.transform = 'scale(1.05)';
  });
  btn.addEventListener('mouseleave', () => {
    btn.style.transform = 'scale(1.0)';
  });
});

// Auto-hide alerts après 5 secondes
setTimeout(() => {
  document.querySelectorAll('.alert').forEach(a => a.classList.add('fade'));
}, 5000);
