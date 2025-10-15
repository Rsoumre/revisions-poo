<?php
// index.php - Job11
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'product.php';
require_once 'category.php';


// Ajouter un produit
$product = new Product();
$product->setName('T-shirt basique');
$product->setPhotos(['tshirt.jpg']);
$product->setPrice(1999);
$product->setDescription('Produit standard');
$product->setQuantity(5);
$product->setCategoryId(1);

if ($product->create()) {
    echo " Produit ajouté avec succès !<br>";
} else {
    echo " Impossible d'ajouter le produit.<br>";
}


// Récupérer un produit

$foundProduct = (new Product())->findOneById($product->getId());
echo "<h3>Produit récupéré :</h3>";
echo "<pre>";
print_r($foundProduct);
echo "</pre>";


// Récupérer la catégorie du produit

$category = $product->getCategory();
echo "<h3>Catégorie du produit :</h3>";
echo "<pre>";
print_r($category);
echo "</pre>";
