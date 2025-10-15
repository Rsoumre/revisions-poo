<?php
class Product {
    protected ?int $id = null;
    protected string $name;
    protected array $photos = [];
    protected int $price;
    protected string $description;
    protected int $quantity;
    protected int $category_id;
    protected string $createdAt;
    protected string $updatedAt;

    protected static $conn;

    public function __construct() {
        if (!self::$conn) {
            self::$conn = new mysqli("localhost", "admin", "root", "draft-shop");
            if (self::$conn->connect_error) {
                die("Erreur de connexion : " . self::$conn->connect_error);
            }
        }
    }

    // === CRUD ===
    public function create(): bool {
        $stmt = self::$conn->prepare(
            "INSERT INTO product (name, photos, price, description, quantity, category_id, createdAt, updatedAt) 
             VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())"
        );

        $photosJson = json_encode($this->photos);
        $stmt->bind_param("ssdsii", $this->name, $photosJson, $this->price, $this->description, $this->quantity, $this->category_id);

        if ($stmt->execute()) {
            $this->id = self::$conn->insert_id;
            return true;
        }
        return false;
    }

    public static function findAll(): array {
        $conn = new self();
        $result = self::$conn->query("SELECT * FROM product");
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $p = new self();
            $p->hydrate($row);
            $products[] = $p;
        }

        return $products;
    }

    public static function findOneById(int $id): self|false {
        $conn = new self();
        $stmt = self::$conn->prepare("SELECT * FROM product WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if ($row) {
            $p = new self();
            $p->hydrate($row);
            return $p;
        }
        return false;
    }

    public function update(): bool {
        if (!$this->id) return false;

        $stmt = self::$conn->prepare(
            "UPDATE product SET name=?, photos=?, price=?, description=?, quantity=?, category_id=?, updatedAt=NOW() WHERE id=?"
        );

        $photosJson = json_encode($this->photos);
        $stmt->bind_param("ssdsiii", $this->name, $photosJson, $this->price, $this->description, $this->quantity, $this->category_id, $this->id);

        return $stmt->execute();
    }

    public function delete(): bool {
        if (!$this->id) return false;
        $stmt = self::$conn->prepare("DELETE FROM product WHERE id = ?");
        $stmt->bind_param("i", $this->id);
        return $stmt->execute();
    }

    // === Hydratation ===
    protected function hydrate(array $data) {
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->photos = json_decode($data['photos'], true);
        $this->price = $data['price'];
        $this->description = $data['description'];
        $this->quantity = $data['quantity'];
        $this->category_id = $data['category_id'];
        $this->createdAt = $data['createdAt'];
        $this->updatedAt = $data['updatedAt'];
    }

    // === Setters ===
    public function setName($name) { $this->name = $name; }
    public function setPhotos($photos) { $this->photos = $photos; }
    public function setPrice($price) { $this->price = $price; }
    public function setDescription($description) { $this->description = $description; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }
    public function setCategoryId($category_id) { $this->category_id = $category_id; }
}
