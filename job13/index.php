<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'product.php';
require_once 'clothing.php';
require_once 'electronic.php';
require_once 'category.php';

// --- Création des catégories ---
$catClothing = new category(1, "vetements");
$catElectronic = new category(2, "electronique");

// --- Création d'un produit vêtement ---
$clothing = new clothing(
    0,                  // id
    "T-shirt Edition Limitée",  // name
    ["shirt.png"],      // photos
    2999,               // price
    "Un superbe T-shirt exclusif", // description
    15,                 // quantity
    $catClothing->getId(),  // category_id
    null,               // createdAt -> null = maintenant
    null,               // updatedAt -> null = maintenant
    "L",                // size
    "Noir",             // color
    "T-shirt",          // type
    150                 // material_fee
);

// --- Création d'un produit électronique ---
$electronic = new electronic(
    0,                      // id
    "Laptop Pro Max",        // name
    ["laptop.png"],          // photos
    149999,                  // price
    "Ordinateur portable de haute performance", // description
    5,                       // quantity
    $catElectronic->getId(), // category_id
    null,                    // createdAt
    null,                    // updatedAt
    "TechCo",                // brand
    2500                     // warranty_fee
);

// --- Sauvegarde en BDD ---
$clothingCreated = $clothing->create();
$electronicCreated = $electronic->create();

if ($clothingCreated) echo "Produit vêtement ajouté avec succès !<br>";
if ($electronicCreated) echo "Produit électronique ajouté avec succès !<br>";

// --- Récupération d'un produit par id ---
$retrievedClothing = clothing::findOneById($clothingCreated->getId());
if ($retrievedClothing) {
    echo "Produit récupéré : " . $retrievedClothing->getName() . " (" . $retrievedClothing->getColor() . ")<br>";
}

// --- Liste de tous les vêtements ---
$allClothing = clothing::findAll();
echo "<h3>Liste de tous les vêtements :</h3>";
foreach ($allClothing as $c) {
    echo $c->getName() . " - " . $c->getColor() . " - " . $c->getSize() . "<br>";
}

// --- Liste de tous les électroniques ---
$allElectronic = electronic::findAll();
echo "<h3>Liste de tous les électroniques :</h3>";
foreach ($allElectronic as $e) {
    echo $e->getName() . " - " . $e->getBrand() . "<br>";
}


