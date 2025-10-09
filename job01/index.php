<?php
// On inclut la classe Product pour pouvoir l'utiliser (chemin relatif basé sur le répertoire courant)
require_once __DIR__ . '/product.php';

// --- Création d'une instance (un objet) de la classe Product ---
// Le constructeur est appelé automatiquement avec les valeurs qu'on passe ici
$product = new Product(
    1, // id
    "T-shirt noir", // name
    ["images/photo2.jpg",], // photos
    2299, // prix (ici 22,99 €)
    "Un t-shirt en coton noir de haute qualité.", // description
    50, // quantité en stock
    new DateTime(), // date de création (date du jour)
    new DateTime()  // date de mise à jour (date du jour)
);



// --- Exemple d'utilisation et rendu simple ---
$product->setPrice(2499); // Change le prix à 24,99 € (exemple)

?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Job01 - Produit</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background:#fafafa }
        .product { display:flex; gap:20px; align-items:flex-start }
        .gallery img { max-width:200px; display:block; margin-bottom:10px; border:1px solid #ddd }
        .meta { max-width:600px }
        .price { font-weight:700; color:#111 }
    </style>
</head>
<body>
    <h1>Produit — <?= htmlspecialchars($product->getName(), ENT_QUOTES) ?></h1>
    <div class="product">
        <div class="gallery">
            <?php foreach ($product->getPhotos() as $src): ?>
                <img src="<?= htmlspecialchars($src, ENT_QUOTES) ?>" alt="<?= htmlspecialchars($product->getName(), ENT_QUOTES) ?>">
            <?php endforeach; ?>
        </div>
        <div class="meta">
            <p class="price">Prix : <?= number_format($product->getPrice() / 100, 2, ',', ' ') ?> €</p>
            <p><?= nl2br(htmlspecialchars($product->getDescription(), ENT_QUOTES)) ?></p>
            <p>Quantité en stock : <?= $product->getQuantity() ?></p>
            <p>Créé le : <?= $product->getCreatedAt()->format('d/m/Y H:i') ?></p>
            <p>Mis à jour : <?= $product->getUpdatedAt()->format('d/m/Y H:i') ?></p>
        </div>
    </div>


</body>
</html>
<?php
