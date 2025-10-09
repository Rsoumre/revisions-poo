<?php
// Exemple d'utilisation des classes Category et Product pour le Job02
// Ce fichier montre comment instancier les objets et accéder à leurs propriétés via getters
require_once __DIR__ . '/category.php';
require_once __DIR__ . '/product.php';

// Création d'une catégorie (id, name, description, createdAt, updatedAt)
$category = new Category(1, 'T-shirts', 'Catégorie de t-shirts', new DateTime(), new DateTime());

// Création d'un produit, en liant la catégorie via category_id
$product = new Product(
    1,
    'T-shirt blanc',
    ['images/photo1.svg', 'images/photo2.svg'], // chemins relatifs vers images (optionnel)
    1999, // prix en centimes
    'Un t-shirt blanc basique.',
    100, // quantité
    $category->getId(), // category_id
    new DateTime(),
    new DateTime()
);

?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Job02 - Category & Product</title>
  <style>body{font-family:Arial,Helvetica,sans-serif;padding:16px}</style>
</head>
<body>
  <h1>Category</h1>
  <ul>
    <li>ID: <?= $category->getId() ?></li>
    <li>Name: <?= htmlspecialchars($category->getName(), ENT_QUOTES) ?></li>
    <li>Description: <?= htmlspecialchars($category->getDescription(), ENT_QUOTES) ?></li>
    <li>Créé: <?= $category->getCreatedAt()->format('d/m/Y H:i') ?></li>
  </ul>

  <h1>Product</h1>
  <ul>
    <li>ID: <?= $product->getId() ?></li>
    <li>Name: <?= htmlspecialchars($product->getName(), ENT_QUOTES) ?></li>
    <li>Category ID: <?= htmlspecialchars((string)$product->getCategoryId(), ENT_QUOTES) ?></li>
    <li>Price: <?= number_format($product->getPrice() / 100, 2, ',', ' ') ?> €</li>
  </ul>

  <!-- Astuce : si vous avez l'objet Category, vous pouvez afficher son nom -->
  <p>Nom de la catégorie (via l'objet Category créé ci-dessus) : <strong><?= htmlspecialchars($category->getName(), ENT_QUOTES) ?></strong></p>

</body>
</html>
