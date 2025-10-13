<?php
require_once __DIR__ . '/product.php';
require_once __DIR__ . '/category.php';

echo "<h2>Job 04 – Chargement d’un produit depuis la base de données</h2>";

try {
    // Connexion à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=draft-shop;charset=utf8', 'admin', 'root');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête : récupérer le produit avec l’id 7
    $stmt = $pdo->prepare("SELECT * FROM product WHERE id = 7");
    $stmt->execute();

    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo "<p> Produit trouvé en base :</p>";
        echo "<pre>";
        print_r($data);
        echo "</pre>";

        // On crée une instance Product vide
        $product = new Product();

        // Hydratation (on met les données dans l’objet)
        $product
            ->setId($data['id'])
            ->setName($data['name'])
            ->setPhotos(json_decode($data['photos'], true) ?? [])
            ->setPrice($data['price'])
            ->setDescription($data['description'])
            ->setQuantity($data['quantity'])
            ->setCategoryId($data['category_id'])
            ->setCreatedAt(new DateTime($data['createdAt']))
            ->setUpdatedAt(new DateTime($data['updatedAt']));

        echo "<p> Objet Product hydraté :</p>";
        echo "<pre>";
        var_dump($product);
        echo "</pre>";
    } else {
        echo "<p> Aucun produit avec l’id 7 trouvé dans la base de données.</p>";
    }
} catch (PDOException $e) {
    echo "<p> Erreur de connexion ou de requête : " . $e->getMessage() . "</p>";
}
?>
