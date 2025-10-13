<?php
require_once 'category.php';
require_once 'product.php';

// Test sans paramètres
$category1 = new Category();
$product1 = new Product();

// Test avec paramètres
$category2 = new Category(1, 'Vêtements', 'Catégorie de vêtements');
$product2 = new Product(1, 'T-shirt blanc', ['photo1.jpg'], 1999, 'Un beau t-shirt', 10, 1);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Job03.1 - Test constructeurs</title>
</head>
<body>
  <h1>Test Job03.1</h1>

  <h2>Catégorie vide :</h2>
  <pre><?php var_dump($category1); ?></pre>

  <h2>Produit vide :</h2>
  <pre><?php var_dump($product1); ?></pre>

  <h2>Catégorie avec données :</h2>
  <pre><?php var_dump($category2); ?></pre>

  <h2>Produit avec données :</h2>
  <pre><?php var_dump($product2); ?></pre>
</body>
</html>
