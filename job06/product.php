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

    // Nouvelle méthode hydrate()
    public function hydrate(array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method)) {
                // Si c’est une date, on la convertit en objet DateTime
                if (in_array($key, ['createdAt', 'updatedAt']) && !($value instanceof DateTime)) {
                    $value = new DateTime($value);
                }

                // Si c’est "photos", on décode le JSON
                if ($key === 'photos' && is_string($value)) {
                    $value = json_decode($value, true) ?? [];
                }

                $this->$method($value);
            }
        }
    }

    //  Méthode pour récupérer la catégorie
    public function getCategory(): ?Category
    {
        if (!$this->category_id) return null;

        $pdo = new PDO('mysql:host=127.0.0.1;dbname=draft-shop;charset=utf8mb4', 'admin', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $stmt = $pdo->prepare('SELECT * FROM category WHERE id = ?');
        $stmt->execute([$this->category_id]);
        $data = $stmt->fetch();

        if ($data) {
            return new Category(
                $data['id'],
                $data['name'],
                $data['description'],
                new DateTime($data['createdAt']),
                new DateTime($data['updatedAt'])
            );
        }
        return null;
    }

    // Getters et setters
    public function setId(int $id): self { $this->id = $id; return $this; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function setPhotos(array $photos): self { $this->photos = $photos; return $this; }
    public function setPrice(int $price): self { $this->price = $price; return $this; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function setQuantity(int $quantity): self { $this->quantity = $quantity; return $this; }
    public function setCategory_id(?int $category_id): self { $this->category_id = $category_id; return $this; }
    public function setCreatedAt(DateTime $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function setUpdatedAt(DateTime $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }

    public function getName(): string { return $this->name; }
}
