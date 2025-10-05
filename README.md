# 🛒 Omnes MarketPlace

Projet de groupe réalisé dans le cadre de la matière **Web Dynamique** à **l’ECE Paris – École d’ingénieurs du numérique**.

Ce projet avait pour objectif de concevoir et développer une **plateforme e-commerce complète**, permettant à différents utilisateurs d’interagir à travers plusieurs modes d’achat : **achat immédiat**, **négociation vendeur-client** et **enchères automatiques**.

---

## 👥 Équipe de projet
Projet réalisé en groupe d’étudiants de 4 étudiants de l'ECE :

Encadré dans le cadre du cours de **Développement Web Dynamique** (PHP / MySQL / HTML / CSS / JS).

---

## 🎯 Objectif pédagogique

- Comprendre le fonctionnement complet d’un **site web dynamique**.  
- Mettre en œuvre une **architecture front-end / back-end**.  
- Manipuler une base de données relationnelle MySQL via PHP.  
- Appliquer les concepts de **sessions, authentification, gestion de rôles et persistance des données**.  
- Produire une interface claire et responsive grâce à **Bootstrap 5**.

---

## 🧩 Fonctionnalités principales

| Fonctionnalité | Description |
|----------------|-------------|
| 👥 **Multi-rôles** | 2 profils : **Vendeur**, **Acheteur** |
| 💳 **Achat immédiat** | Achat direct d’un produit au prix affiché |
| 💬 **Négociation vendeur-client** | Jusqu’à 5 tours de propositions/contre-propositions |
| ⚖️ **Enchères (meilleure offre)** | Système d’enchères automatiques avec enchère max |
| 🛍️ **Panier et paiement** | Gestion de panier + paiement simulé via carte de test |
| 🧑‍💼 **Espace Admin** | Gestion des vendeurs et des articles |
| 🧾 **Espace Vendeur** | CRUD produits + suivi des négociations |
| 👩‍💻 **Espace Acheteur** | Consultation, négociation, enchères et panier |
| 🔒 **Connexion sécurisée** | Authentification + hachage des mots de passe |

---

## 🧱 Stack technique

- **Front-end :** HTML5, CSS3, Bootstrap 5, JavaScript  
- **Back-end :** PHP 8.2 (Programmation orientée objet partielle)  
- **Base de données :** MySQL (via phpMyAdmin)  
- **Environnement :** XAMPP (Apache + MariaDB)  
- **Versioning :** Git / GitHub

---

## ⚙️ Installation locale (XAMPP)

1️⃣ **Cloner le projet :**
```bash
git clone https://github.com/EvaneLipou/OmnesMarketPlace.git
```

2️⃣ **Placer le dossier dans :**
```
C:\xampp\htdocs\OmnesMarketPlace\
```

3️⃣ **Importer la base de données :**
- Ouvre [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
- Clique sur **Importer**
- Sélectionne le fichier : `sql/init.sql`
- Exécute → la base `OmnesMarketPlace` sera créée 🎉

4️⃣ **Démarre Apache et MySQL** depuis le XAMPP Control Panel

5️⃣ **Lance le site :**
[http://localhost/OmnesMarketPlace/](http://localhost/OmnesMarketPlace/)

---

## 👤 Comptes de test

| Rôle | Email | Mot de passe |
|------|--------|--------------|
| 👑 Administrateur | `admin@omnes.fr` | `admin123` |
| 🧑‍💼 Vendeur | `vendeur@omnes.fr` | `vendeur123` |
| 👩‍🛒 Acheteur | `acheteur@omnes.fr` | `acheteur123` |

Carte de paiement de test :
```
Numéro : 4111 1111 1111 1111
Exp : 12/27
CVC : 123
```

---

## 🧠 Ce que le projet démontre

✔️ Maîtrise du développement **web dynamique** (PHP / MySQL)  
✔️ Mise en place d’un système **multi-rôles** sécurisé  
✔️ Gestion d’une **base de données relationnelle complète**  
✔️ Utilisation d’un **framework CSS (Bootstrap)** pour le responsive  
✔️ Architecture claire et modulaire (includes, pages, assets, sql)

---

## 📜 Licence

Projet académique – ECE Paris  
Usage libre à des fins pédagogiques et de présentation.
