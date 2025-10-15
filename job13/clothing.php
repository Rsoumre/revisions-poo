<?php
require_once 'product.php';

class clothing extends abstractProduct
{
    private string $size;
    private string $color;
    private string $type;
    private int $material_fee;

    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        int $price = 0,
        string $description = '',
        int $quantity = 0,
        ?int $category_id = null,
        null|string|DateTime $createdAt = null,
        null|string|DateTime $updatedAt = null,
        string $size = '',
        string $color = '',
        string $type = '',
        int $material_fee = 0
    ) {
        // Si ce sont des strings, on les convertit en DateTime
        if (is_string($createdAt)) {
            $createdAt = new DateTime($createdAt);
        }
        if (is_string($updatedAt)) {
            $updatedAt = new DateTime($updatedAt);
        }

        parent::__construct($id, $name, $photos, $price, $description, $quantity, $category_id, $createdAt, $updatedAt);
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }

    public function getSize(): string { return $this->size; }
    public function getColor(): string { return $this->color; }
    public function getType(): string { return $this->type; }
    public function getMaterialFee(): int { return $this->material_fee; }

    public function setSize(string $size): self { $this->size = $size; return $this; }
    public function setColor(string $color): self { $this->color = $color; return $this; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function setMaterialFee(int $material_fee): self { $this->material_fee = $material_fee; return $this; }

    // Méthodes concrètes pour DB
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

        // Insert child
        $stmt2 = $pdo->prepare('INSERT INTO clothing (product_id, size, color, type, material_fee) VALUES (:pid, :size, :color, :type, :fee)');
        $stmt2->execute([
            ':pid' => $this->id,
            ':size' => $this->size,
            ':color' => $this->color,
            ':type' => $this->type,
            ':fee' => $this->material_fee
        ]);

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

        $stmt2 = $pdo->prepare('UPDATE clothing SET size=:size, color=:color, type=:type, material_fee=:fee WHERE product_id=:id');
        return $stmt2->execute([
            ':size' => $this->size,
            ':color' => $this->color,
            ':type' => $this->type,
            ':fee' => $this->material_fee,
            ':id' => $this->id
        ]);
    }

    public static function findOneById(int $id): self|false
    {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('SELECT * FROM product p JOIN clothing c ON p.id=c.product_id WHERE p.id=?');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        if (!$row) return false;

        $photos = json_decode($row['photos'], true) ?? [];
        return new self(
            (int)$row['id'], $row['name'], $photos, (int)$row['price'], $row['description'], (int)$row['quantity'],
            isset($row['category_id']) ? (int)$row['category_id'] : null,
            $row['createdAt'] ?? $row['created_at'],
            $row['updatedAt'] ?? $row['updated_at'],
            $row['size'], $row['color'], $row['type'], (int)$row['material_fee']
        );
    }

    public static function findAll(): array
    {
        $pdo = self::getPDO();
        $stmt = $pdo->query('SELECT * FROM product p JOIN clothing c ON p.id=c.product_id ORDER BY p.id');
        $rows = $stmt->fetchAll();
        $results = [];
        foreach ($rows as $row) {
            $photos = json_decode($row['photos'], true) ?? [];
            $results[] = new self(
                (int)$row['id'], $row['name'], $photos, (int)$row['price'], $row['description'], (int)$row['quantity'],
                isset($row['category_id']) ? (int)$row['category_id'] : null,
                $row['createdAt'] ?? $row['created_at'],
                $row['updatedAt'] ?? $row['updated_at'],
                $row['size'], $row['color'], $row['type'], (int)$row['material_fee']
            );
        }
        return $results;
    }
}
