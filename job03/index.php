<?php
/**
 * job03/index.php
 * Page d'affichage des produits depuis la base `draft-shop`.
 *
 * Notes de lecture rapide:
 * - Cette page utilise PDO pour se connecter à MySQL.
 * - Les variables de configuration ($host, $user, $pass) doivent être adaptées
 *   à votre environnement (XAMPP, MAMP, LAMP...).
 * - Les prix sont stockés en centimes (ex: 1999 => 19.99 €).
 */

// --- Configuration de la base de données (à adapter si nécessaire) ---
$host = '127.0.0.1';
$db   = 'draft-shop';
$user = 'admin';
$pass = 'root'; // change selon ton serveur local
$charset = 'utf8mb4';

// DSN et options PDO: on active les exceptions et le fetch associatif
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

// Connexion PDO: entourer d'un try/catch pour afficher une erreur lisible
try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  // htmlspecialchars empêche l'affichage direct d'éventuels caractères dangereux
  die("Erreur de connexion : " . htmlspecialchars($e->getMessage()));
}

// --- Requête pour récupérer les produits et leurs catégories ---
// On joint la table `category` pour afficher le nom de catégorie associé
$sql = "SELECT p.*, c.name AS category_name
    FROM product p
    JOIN category c ON p.category_id = c.id
    ORDER BY p.id";

// Ici on utilise query() car il n'y a pas de paramètre utilisateur
$stmt = $pdo->query($sql);
$products = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Job03 - Liste des produits</title>
  <style>
    body { font-family: Arial; padding: 20px; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #aaa; padding: 8px; text-align: left; }
    img { max-height: 60px; margin-right: 6px; }
  </style>
</head>
<body>
  <h1> Produits disponibles</h1>
  <p><a href="seed.php"> Lancer le seed (insérer les données)</a></p>

<?php if (empty($products)): ?>
  <p>Aucun produit trouvé. Lance <code>seed.php</code> pour insérer des exemples.</p>
<?php else: ?>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Photos</th>
        <th>Prix</th>
        <th>Quantité</th>
        <th>Catégorie</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($products as $p): ?>
      <tr>
        <td><?= htmlspecialchars($p['id']) ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td>
          <?php
          $photos = json_decode($p['photos'], true);
          if (is_array($photos)) {
              foreach ($photos as $ph) {
                  $url = 'images/' . basename($ph);
                  if (file_exists(__DIR__ . '/' . $url)) {
                      echo '<img src="' . htmlspecialchars($url) . '" alt="">';
                  } else {
                      echo htmlspecialchars($ph) . ' ';
                  }
              }
          } else {
              echo htmlspecialchars($p['photos']);
          }
          ?>
        </td>
        <td><?= number_format($p['price'] / 100, 2, ',', ' ') ?> €</td>
        <td><?= htmlspecialchars($p['quantity']) ?></td>
        <td><?= htmlspecialchars($p['category_name']) ?></td>
        <td><?= htmlspecialchars($p['description']) ?></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php endif; ?>

</body>
</html>
