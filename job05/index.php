<?php
require_once 'category.php';
require_once 'product.php';

// Connexion à la base de données
$host = '127.0.0.1';
$db   = 'draft-shop';
$user = 'admin';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Erreur de connexion : " . htmlspecialchars($e->getMessage()));
}

// Récupération du produit id 7
$stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
$stmt->execute([7]);
$data = $stmt->fetch();

if ($data) {
    // Hydratation de l'objet Product
    $product = new Product(
        $data['id'],
        $data['name'],
        json_decode($data['photos'], true),
        $data['price'],
        $data['description'],
        $data['quantity'],
        $data['category_id'],
        new DateTime($data['createdAt']),
        new DateTime($data['updatedAt'])
    );

    // Récupération de la catégorie via la méthode getCategory()
    $category = $product->getCategory($pdo);

    echo "<h2>Produit : " . htmlspecialchars($product->getName()) . "</h2>";
    echo "<p>Prix : " . number_format($product->getPrice()/100, 2, ',', ' ') . " €</p>";
    echo "<p>Description : " . htmlspecialchars($product->getDescription()) . "</p>";
    echo "<p>Quantité : " . $product->getQuantity() . "</p>";

    if ($category) {
        echo "<p>Catégorie : " . htmlspecialchars($category->getName()) . " (" . htmlspecialchars($category->getDescription()) . ")</p>";
    } else {
        echo "<p>Aucune catégorie trouvée</p>";
    }

    echo "<p>Photos :</p>";
    foreach ($product->getPhotos() as $photo) {
        echo '<img src="images/' . htmlspecialchars($photo) . '" alt="" style="max-height:80px;margin-right:6px">';
    }

} else {
    echo "Aucun produit trouvé avec l'id 7";
}
?>
