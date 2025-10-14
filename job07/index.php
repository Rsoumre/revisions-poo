<?php


require_once 'product.php';
require_once 'category.php';

// Crée une instance vide puis recherche
$product = new Product();

$result = $product->findOneById(7);

if ($result === false) {
    echo "Aucun produit trouvé avec l'id 7.";
    exit;
}

// $product est hydraté : affiche proprement
echo "<h1>" . htmlspecialchars($product->getName()) . "</h1>";
echo "<p>Prix : " . number_format($product->getPrice() / 100, 2, ',', ' ') . " €</p>";
echo "<p>Description : " . nl2br(htmlspecialchars($product->getDescription())) . "</p>";
echo "<p>Quantité : " . $product->getQuantity() . "</p>";

// photos
echo "<div>";
foreach ($product->getPhotos() as $ph) {
    $url = 'images/' . basename($ph);
    echo '<img src="'.htmlspecialchars($url).'" style="max-height:80px;margin-right:6px">';
}
echo "</div>";

// on peut récupérer la catégorie si getCategory() existe (elle prend $pdo en version précédente)
// si ta getCategory() attend un PDO, tu peux adapter ; sinon, si elle crée sa propre connexion, c'est bon :
if (method_exists($product, 'getCategory')) {
    // si getCategory prend un PDO, passe-le ; sinon appelle sans param
    $category = (new ReflectionMethod($product, 'getCategory'))->getNumberOfParameters() ? $product->getCategory($pdo) : $product->getCategory();
    if ($category) {
        echo "<p>Catégorie : " . htmlspecialchars($category->getName()) . "</p>";
    }
}
