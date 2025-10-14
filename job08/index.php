<?php
require_once 'product.php';
require_once 'category.php';

$products = Product::findAll();

if (empty($products)) {
    echo "<p>Aucun produit trouvé dans la base.</p>";
    exit;
}

echo "<h1>Liste des produits</h1>";

// Nouveau tableau simplifié sans Photos et Prix
echo "<table border='1' cellpadding='6'>";
echo "<thead><tr><th>ID</th><th>Nom</th><th>Quantité</th><th>Catégorie</th><th>Description</th></tr></thead>";
echo "<tbody>";

foreach ($products as $p) {
    echo "<tr>";
    echo "<td>".$p->getId()."</td>";
    echo "<td>".htmlspecialchars($p->getName())."</td>";
    echo "<td>".$p->getQuantity()."</td>";
    echo "<td>".$p->getCategoryId()."</td>"; // ou utiliser $p->getCategory()->getName() si tu veux le nom réel
    echo "<td>".nl2br(htmlspecialchars($p->getDescription()))."</td>";
    echo "</tr>";
}

echo "</tbody></table>";
