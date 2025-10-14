<?php
require_once 'product.php';
require_once 'category.php';

// Création d'une nouvelle instance de Product
$newProduct = new Product(
    0,                          
    'Montre connectée',        
    ['photo1.jpg'],             
    4999,                       
    'Montre intelligente avec notifications',
    15,                         
    2                          
);

// On insère le produit en base
$result = $newProduct->create();

if ($result) {
    echo "<h2>Produit créé avec succès !</h2>";
    echo "<p>ID : " . $result->getId() . "</p>";
    echo "<p>Nom : " . htmlspecialchars($result->getName()) . "</p>";
    echo "<p>Prix : " . number_format($result->getPrice() / 100, 2, ',', ' ') . " €</p>";
    echo "<p>Description : " . nl2br(htmlspecialchars($result->getDescription())) . "</p>";
    echo "<p>Quantité : " . $result->getQuantity() . "</p>";



    // Récupération de la catégorie
    if (method_exists($result, 'getCategory')) {
        $category = $result->getCategory();
        if ($category) {
            echo "<p>Catégorie : " . htmlspecialchars($category->getName()) . "</p>";
        }
    }
} else {
    echo "<p>Erreur lors de la création du produit.</p>";
}
