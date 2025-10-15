<?php
require_once 'category.php';
require_once 'clothing.php';
require_once 'electronic.php';

// Création de vêtements
$clothing = new Clothing(
    name: 'T-shirt Edition Limitée',
    color: 'Noir',
    size: 'L',
    quantity: 10,
    category_id: 1
);
$clothing->create()->addStocks(5)->removeStocks(3);
echo "Produit vêtement ajouté avec succès !\n";

// Création d'électronique
$electronic = new Electronic(
    name: 'Laptop Pro Max',
    brand: 'TechCo',
    quantity: 20,
    category_id: 2
);
$electronic->create()->addStocks(10)->removeStocks(5);
echo "Produit électronique ajouté avec succès !\n";
