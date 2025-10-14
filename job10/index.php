<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'product.php';
require_once 'category.php';

echo "<h1>Mise à jour d’un produit</h1>";

// Crée un objet Product vide
$product = new Product();

// On tente de récupérer le produit id = 7
$found = $product->findOneById(7);

if (!$found) {
    echo "<p>Produit non trouvé ! Création d’un nouveau produit...</p>";

    // Création automatique d’un nouveau produit
    $product->setName("Casque audio");
    $product->setPhotos(["photo4.webp"]);
    $product->setPrice(2499);
    $product->setDescription("Casque Bluetooth sans fil haute qualité");
    $product->setQuantity(20);
    $product->setCategoryId(1);
    $product->create();

    echo "<p> Produit créé avec l’ID : {$product->getId()}</p>";
}

// Mise à jour de certaines valeurs
$product->setPrice(1999);
$product->setQuantity(15);
$product->setDescription("Casque audio mis à jour - nouvelle version 2025");
$product->setUpdatedAt(new DateTime());

if ($product->update()) {
    echo "<p> Produit mis à jour avec succès.</p>";
} else {
    echo "<p> Échec de la mise à jour.</p>";
}

// Affichage du produit actualisé
echo "<pre>";
print_r($product);
echo "</pre>";
