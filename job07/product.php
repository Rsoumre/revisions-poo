<?php

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

    //  Méthode demandée dans le Job06
    public function findOneById(int $id)
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
            return false;
        }

        $stmt = $pdo->prepare('SELECT * FROM product WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();

        if (!$row) return false;

        $this->setId((int)$row['id']);
        $this->setName((string)$row['name']);
        $photos = is_string($row['photos']) ? (json_decode($row['photos'], true) ?? []) : $row['photos'];
        $this->setPhotos($photos);
        $this->setPrice((int)$row['price']);
        $this->setDescription((string)$row['description']);
        $this->setQuantity((int)$row['quantity']);
        $this->setCategoryId(isset($row['category_id']) ? (int)$row['category_id'] : null);
        $this->setCreatedAt(new DateTime($row['createdAt'] ?? 'now'));
        $this->setUpdatedAt(new DateTime($row['updatedAt'] ?? 'now'));

        return $this;
    }

    //  Getters
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPhotos(): array { return $this->photos; }
    public function getPrice(): int { return $this->price; }
    public function getDescription(): string { return $this->description; }
    public function getQuantity(): int { return $this->quantity; }
    public function getCategoryId(): ?int { return $this->category_id; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function getUpdatedAt(): DateTime { return $this->updatedAt; }

    //  Setters
    public function setId(int $id): self { $this->id = $id; return $this; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function setPhotos(array $photos): self { $this->photos = $photos; return $this; }
    public function setPrice(int $price): self { $this->price = $price; return $this; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function setQuantity(int $quantity): self { $this->quantity = $quantity; return $this; }
    public function setCategoryId(?int $category_id): self { $this->category_id = $category_id; return $this; }
    public function setCreatedAt(DateTime $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function setUpdatedAt(DateTime $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }

    //  Récupérer la catégorie associée (depuis Job05)
    public function getCategory(): ?Category
    {
        if ($this->category_id === null) {
            return null;
        }

        $host = '127.0.0.1';
        $db   = 'draft-shop';
        $user = 'admin';
        $pass = 'root';
        $charset = 'utf8mb4';
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        $stmt = $pdo->prepare('SELECT * FROM category WHERE id = ?');
        $stmt->execute([$this->category_id]);
        $row = $stmt->fetch();

        if (!$row) {
            return null;
        }

        return new Category(
            (int)$row['id'],
            $row['name'],
            $row['description'],
            new DateTime($row['createdAt'] ?? 'now'),
            new DateTime($row['updatedAt'] ?? 'now')
        );
    }
}
