<?php


require_once __DIR__ . '/vendor/autoload.php';

use App\Clothing;
use App\Electronic;

// Création d'un vêtement et ajout de stock
$shirt = new Clothing(name: "T-shirt", quantity: 10, price: 20, size: "M", color: "Noir");
$shirt->addStocks(5);
echo "Quantité T-shirt: " . $shirt->getQuantity() . PHP_EOL;

// Création d'un produit électronique
$laptop = new Electronic(name: "Laptop", quantity: 5, price: 1000, brand: "TechBrand");
$laptop->removeStocks(2);
echo "Quantité Laptop: " . $laptop->getQuantity() . PHP_EOL;

// Affichage de tous les vêtements
echo "Liste des vêtements:" . PHP_EOL;
foreach (Clothing::findAll() as $item) {
    echo $item->getName() . " - " . $item->getColor() . " - " . $item->getSize() . PHP_EOL;
}

// Affichage de tous les électroniques
echo "Liste des électroniques:" . PHP_EOL;
foreach (Electronic::findAll() as $item) {
    echo $item->getName() . " - " . $item->getBrand() . PHP_EOL;
}
