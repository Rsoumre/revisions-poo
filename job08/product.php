<?php

require_once 'category.php';

class Product
{
    private int $id;
    private string $name;
    private array $photos;
    private int $price;
    private string $description;
    private int $quantity;
    private ?int $category_id;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        int $price = 0,
        string $description = '',
        int $quantity = 0,
        ?int $category_id = null,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->category_id = $category_id;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
    }

    // -----------------
    // Getters
    // -----------------
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPhotos(): array { return $this->photos; }
    public function getPrice(): int { return $this->price; }
    public function getDescription(): string { return $this->description; }
    public function getQuantity(): int { return $this->quantity; }
    public function getCategoryId(): ?int { return $this->category_id; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function getUpdatedAt(): DateTime { return $this->updatedAt; }

    // -----------------
    // Setters
    // -----------------
    public function setId(int $id): self { $this->id = $id; return $this; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function setPhotos(array $photos): self { $this->photos = $photos; return $this; }
    public function setPrice(int $price): self { $this->price = $price; return $this; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function setQuantity(int $quantity): self { $this->quantity = $quantity; return $this; }
    public function setCategoryId(?int $category_id): self { $this->category_id = $category_id; return $this; }
    public function setCreatedAt(DateTime $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function setUpdatedAt(DateTime $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }

    // -----------------
    // Méthodes spécifiques
    // -----------------

   
    public function getCategory(): ?Category
    {
        if ($this->category_id === null) return null;

        $host = '127.0.0.1';
        $db   = 'draft-shop';
        $user = 'admin';
        $pass = 'root';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            echo "Erreur DB: " . htmlspecialchars($e->getMessage());
            return null;
        }

        $stmt = $pdo->prepare("SELECT * FROM category WHERE id = ?");
        $stmt->execute([$this->category_id]);
        $row = $stmt->fetch();

        if (!$row) return null;

        return new Category(
            (int)$row['id'],
            (string)$row['name'],
            (string)$row['description'],
            new DateTime($row['created_at'] ?? 'now'),
            new DateTime($row['updated_at'] ?? 'now')
        );
    }

   
    public static function findAll(): array
    {
        $host = '127.0.0.1';
        $db   = 'draft-shop';
        $user = 'admin';
        $pass = 'root';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        try {
            $pdo = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch (PDOException $e) {
            echo "Erreur DB: " . htmlspecialchars($e->getMessage());
            return [];
        }

        $stmt = $pdo->query("SELECT * FROM product ORDER BY id");
        $rows = $stmt->fetchAll();

        $products = [];
        foreach ($rows as $row) {
            $photos = is_string($row['photos']) ? (json_decode($row['photos'], true) ?? []) : $row['photos'];
            $products[] = new Product(
                (int)$row['id'],
                (string)$row['name'],
                $photos,
                (int)$row['price'],
                (string)$row['description'],
                (int)$row['quantity'],
                isset($row['category_id']) ? (int)$row['category_id'] : null,
                new DateTime($row['createdAt'] ?? $row['created_at'] ?? 'now'),
                new DateTime($row['updatedAt'] ?? $row['updated_at'] ?? 'now')
            );
        }

        return $products;
    }
}
