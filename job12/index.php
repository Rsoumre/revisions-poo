<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'clothing.php';
require_once 'electronic.php';

// === TEST 1 : Ajout d’un vêtement ===
$shirt = new Clothing();
$shirt->setName("T-shirt Edition Limitée");
$shirt->setPhotos(["shirt.png"]);
$shirt->setPrice(2999);
$shirt->setDescription("Un superbe T-shirt exclusif");
$shirt->setQuantity(15);
$shirt->setCategoryId(1);
$shirt->setSize("L");
$shirt->setColor("Noir");
$shirt->setType("T-shirt");
$shirt->setMaterialFee(150);

if ($shirt->create()) {
    echo " Vêtement ajouté avec succès !<br>";
} else {
    echo " Erreur d’ajout.<br>";
}

// === TEST 2 : Ajout d’un produit électronique ===
$laptop = new Electronic();
$laptop->setName("Laptop Pro Max");
$laptop->setPhotos(["laptop.png"]);
$laptop->setPrice(149999);
$laptop->setDescription("Ordinateur portable de haute performance");
$laptop->setQuantity(5);
$laptop->setCategoryId(2);
$laptop->setBrand("TechCo");
$laptop->setWarrantyFee(2500);

if ($laptop->create()) {
    echo " Produit électronique ajouté avec succès !<br>";
} else {
    echo " Erreur d’ajout.<br>";
}
