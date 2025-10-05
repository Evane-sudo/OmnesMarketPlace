-- ===================================================
-- Omnes MarketPlace - Script d'initialisation SQL
-- Base complète avec données de test
-- ===================================================

DROP DATABASE IF EXISTS OmnesMarketPlace;
CREATE DATABASE OmnesMarketPlace CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE OmnesMarketPlace;

-- =====================
-- 1. Table des utilisateurs
-- =====================
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  role ENUM('admin','vendor','buyer') NOT NULL,
  prenom VARCHAR(50),
  nom VARCHAR(50),
  email VARCHAR(100) UNIQUE,
  password_hash VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =====================
-- 2. Table des produits
-- =====================
CREATE TABLE items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  vendor_id INT,
  nom VARCHAR(100),
  description TEXT,
  prix DECIMAL(10,2),
  type_vente ENUM('IMMEDIATE','NEGOCIATION','ENCHERE'),
  statut ENUM('EN_VENTE','VENDU') DEFAULT 'EN_VENTE',
  image_url VARCHAR(255),
  categorie VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (vendor_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =====================
-- 3. Table des paiements (carte de test)
-- =====================
CREATE TABLE payments (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulaire VARCHAR(100),
  numero VARCHAR(20),
  exp VARCHAR(5),
  cvc VARCHAR(4)
);

-- =====================
-- 4. Tables pour la négociation
-- =====================
CREATE TABLE negotiations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_id INT NOT NULL,
  buyer_id INT NOT NULL,
  vendor_id INT NOT NULL,
  tour_count INT DEFAULT 0,
  statut ENUM('EN_COURS','ACCEPTEE','REFUSEE','EXPIREE') DEFAULT 'EN_COURS',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE,
  FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (vendor_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE negotiation_offers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  negotiation_id INT NOT NULL,
  emetteur ENUM('BUYER','VENDOR') NOT NULL,
  prix_propose DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (negotiation_id) REFERENCES negotiations(id) ON DELETE CASCADE
);

-- =====================
-- 5. Tables pour les enchères
-- =====================
CREATE TABLE auctions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  item_id INT UNIQUE NOT NULL,
  debut_at DATETIME NOT NULL,
  fin_at DATETIME NOT NULL,
  FOREIGN KEY (item_id) REFERENCES items(id) ON DELETE CASCADE
);

CREATE TABLE bids (
  id INT AUTO_INCREMENT PRIMARY KEY,
  auction_id INT NOT NULL,
  buyer_id INT NOT NULL,
  max_offer DECIMAL(10,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (auction_id) REFERENCES auctions(id) ON DELETE CASCADE,
  FOREIGN KEY (buyer_id) REFERENCES users(id) ON DELETE CASCADE
);

-- =====================
-- 6. Comptes utilisateurs de test
-- =====================
INSERT INTO users (role, prenom, nom, email, password_hash) VALUES
('admin','Admin','Principal','admin@omnes.fr',  '$2y$10$wW2wskn6f.1nqMTt8PdxdeWcElrx.3F6aJpFlEo6CQAF3gCQz9k2K'),
('vendor','Vendeur','Pro','vendeur@omnes.fr',    '$2y$10$F1M7IXNUcQtx4DPKDB7nZeUmKT6AZrqIxNprTgOPFMNQh0n7hxJrK'),
('buyer','Acheteur','Test','acheteur@omnes.fr',  '$2y$10$w1YJxN0VviHfghuV9Qd/EOG14T0xvScu6Zh8RxnLRYXdzbIVvH2sy');

-- =====================
-- 7. Produits exemples
-- =====================
INSERT INTO items (vendor_id, nom, description, prix, type_vente, image_url, categorie) VALUES
(2, 'Casque Audio Pro', 'Casque circum-aural avec réduction active de bruit.', 129.90, 'IMMEDIATE', 'https://picsum.photos/seed/casque/600/400', 'Accessoire VIP'),
(2, 'Table basse design', 'Table en bois massif, finition chêne naturel.', 89.00, 'NEGOCIATION', 'https://picsum.photos/seed/table/600/400', 'Meubles/Art'),
(2, 'Pièce rare de collection', 'Objet de collection unique pour enchères.', 300.00, 'ENCHERE', 'https://picsum.photos/seed/rare/600/400', 'Articles rares');

-- =====================
-- 8. Enchère active
-- =====================
INSERT INTO auctions (item_id, debut_at, fin_at)
VALUES (3, NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY));

-- =====================
-- 9. Carte de paiement de test
-- =====================
INSERT INTO payments (titulaire, numero, exp, cvc)
VALUES ('John Demo', '4111111111111111', '12/27', '123');

-- ===================================================
-- Base prête à l’emploi : utilisateurs, produits,
-- enchère active et carte de paiement de test.
-- ===================================================
