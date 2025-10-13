<?php
require_once 'product.php';

try {
    $pdo = new PDO(
        'mysql:host=127.0.0.1;dbname=draft-shop;charset=utf8mb4',
        'admin',
        'root',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    $stmt = $pdo->prepare('SELECT * FROM product WHERE id = ?');
    $stmt->execute([7]);
    $data = $stmt->fetch();

    echo "<h2>Job 06 – Hydratation automatique</h2>";

    if ($data) {
        echo "<pre>Produit trouvé en base :\n";
        print_r($data);
        echo "</pre>";

        //  Hydratation automatique
        $product = new Product();
        $product->hydrate($data);

        echo "<h3>Objet Product hydraté :</h3><pre>";
        var_dump($product);
        echo "</pre>";

        //  Récupération de la catégorie associée
        $category = $product->getCategory();
        if ($category) {
            echo "<p><strong>Catégorie :</strong> {$category->getName()} ({$category->getDescription()})</p>";
        } else {
            echo "<p>Aucune catégorie trouvée.</p>";
        }

    } else {
        echo "<p>Aucun produit trouvé avec l’id 7.</p>";
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
