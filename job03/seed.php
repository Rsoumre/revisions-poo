<?php

// --- Connexion à MySQL (sans base au départ) ---
$host = '127.0.0.1';
$user = 'admin';
$pass = 'root'; 
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // En cas d'échec, on arrête le script avec un message lisible
    die("Connexion impossible : " . htmlspecialchars($e->getMessage()));
}

// --- Création de la base si nécessaire ---
$pdo->exec("CREATE DATABASE IF NOT EXISTS `draft-shop` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
$pdo->exec("USE `draft-shop`");

// --- Création des tables ---
// On crée `category` puis `product` (product référence category)
$pdo->exec(
"CREATE TABLE IF NOT EXISTS category (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");

$pdo->exec(
"CREATE TABLE IF NOT EXISTS product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    photos TEXT NOT NULL,
    price INT NOT NULL,
    description TEXT NOT NULL,
    quantity INT NOT NULL,
    category_id INT NOT NULL,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES category(id)
)");

// --- Insertion des données (transaction) ---
// Utiliser une transaction garantit que les insertions sont atomiques.
$pdo->beginTransaction();
try {
    // Insère deux catégories d'exemple
    $pdo->exec("INSERT INTO category (name, description) VALUES
        ('Vetements', 'Articles vestimentaires'),
        ('Electronique', 'Accessoires et appareils électroniques')");

    // Insère deux produits. Les photos sont stockées en JSON (liste de fichiers)
    $pdo->exec("INSERT INTO product (name, photos, price, description, quantity, category_id)
        VALUES
        ('T-shirt noir', '[\"photo1.jpg\"]', 1999, 'T-shirt en coton noir confortable.', 50, 1),
        ('Casque audio', '[\"casque.jpg\"]', 5999, 'Casque Bluetooth sans fil haute qualité.', 20, 2)");

    $pdo->commit();
    echo "Base et données créées avec succès ! <a href='index.php'>Voir les produits</a>";
} catch (PDOException $e) {
    // En cas d'erreur on annule la transaction pour éviter des données partielles
    $pdo->rollBack();
    echo "Erreur lors de l’insertion : " . htmlspecialchars($e->getMessage());
}
