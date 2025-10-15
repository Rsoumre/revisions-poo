<?php
require_once 'product.php';

class Electronic extends AbstractProduct
{
    private string $brand;
    private int $warranty_fee;

    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        int $price = 0,
        string $description = '',
        int $quantity = 0,
        ?int $category_id = null,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        string $brand = '',
        int $warranty_fee = 0
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $category_id, $createdAt, $updatedAt);
        $this->brand = $brand;
        $this->warranty_fee = $warranty_fee;
    }

    public function getBrand(): string { return $this->brand; }
    public function getWarrantyFee(): int { return $this->warranty_fee; }
    public function setBrand(string $brand): self { $this->brand = $brand; return $this; }
    public function setWarrantyFee(int $warranty_fee): self { $this->warranty_fee = $warranty_fee; return $this; }

    public function create(): self|false
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('INSERT INTO product (name, photos, price, description, quantity, category_id, createdAt, updatedAt) VALUES 
            (:name, :photos, :price, :description, :quantity, :category_id, :createdAt, :updatedAt)');
        $success = $stmt->execute([
            ':name' => $this->name,
            ':photos' => json_encode($this->photos),
            ':price' => $this->price,
            ':description' => $this->description,
            ':quantity' => $this->quantity,
            ':category_id' => $this->category_id,
            ':createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            ':updatedAt' => $this->updatedAt->format('Y-m-d H:i:s')
        ]);
        if (!$success) return false;
        $this->id = (int)$pdo->lastInsertId();

        $stmt2 = $pdo->prepare('INSERT INTO electronic (product_id, brand, warranty_fee) VALUES (:pid, :brand, :warranty)');
        $stmt2->execute([':pid'=>$this->id, ':brand'=>$this->brand, ':warranty'=>$this->warranty_fee]);
        return $this;
    }

    public function update(): bool
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('UPDATE product SET name=:name, photos=:photos, price=:price, description=:description, quantity=:quantity, category_id=:cat, updatedAt=NOW() WHERE id=:id');
        $ok = $stmt->execute([
            ':name' => $this->name,
            ':photos' => json_encode($this->photos),
            ':price' => $this->price,
            ':description' => $this->description,
            ':quantity' => $this->quantity,
            ':cat' => $this->category_id,
            ':id' => $this->id
        ]);
        if (!$ok) return false;

        $stmt2 = $pdo->prepare('UPDATE electronic SET brand=:brand, warranty_fee=:warranty WHERE product_id=:id');
        return $stmt2->execute([':brand'=>$this->brand, ':warranty'=>$this->warranty_fee, ':id'=>$this->id]);
    }

    public static function findOneById(int $id): self|false
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM product p JOIN electronic e ON p.id=e.product_id WHERE p.id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return false;
        $photos = json_decode($row['photos'], true) ?? [];
        return new self(
            (int)$row['id'], $row['name'], $photos, (int)$row['price'], $row['description'], (int)$row['quantity'],
            isset($row['category_id']) ? (int)$row['category_id'] : null,
            new DateTime($row['createdAt'] ?? $row['created_at']),
            new DateTime($row['updatedAt'] ?? $row['updated_at']),
            $row['brand'], (int)$row['warranty_fee']
        );
    }

    public static function findAll(): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM product p JOIN electronic e ON p.id=e.product_id ORDER BY p.id');
        $rows = $stmt->fetchAll();
        $results = [];
        foreach ($rows as $row) {
            $photos = json_decode($row['photos'], true) ?? [];
            $results[] = new self(
                (int)$row['id'], $row['name'], $photos, (int)$row['price'], $row['description'], (int)$row['quantity'],
                isset($row['category_id']) ? (int)$row['category_id'] : null,
                new DateTime($row['createdAt'] ?? $row['created_at']),
                new DateTime($row['updatedAt'] ?? $row['updated_at']),
                $row['brand'], (int)$row['warranty_fee']
            );
        }
        return $results;
    }
}
