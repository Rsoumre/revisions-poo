<?php
require_once 'product.php';
require_once 'StockableInterface.php';

class Clothing extends AbstractProduct implements StockableInterface
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
        int $category_id = 1,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        string $size = '',
        string $color = '',
        string $type = '',
        int $material_fee = 0
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $category_id, $createdAt, $updatedAt);
        $this->size = $size;
        $this->color = $color;
        $this->type = $type;
        $this->material_fee = $material_fee;
    }

    public function addStocks(int $stock): self {
        $this->quantity += $stock;
        return $this;
    }

    public function removeStocks(int $stock): self {
        $this->quantity = max(0, $this->quantity - $stock);
        return $this;
    }

    // Les méthodes CRUD (simplifiées)
    public function create(): self|false {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare(
            'INSERT INTO product (name, photos, price, description, quantity, category_id, createdAt, updatedAt)
            VALUES (:name, :photos, :price, :description, :quantity, :cat, NOW(), NOW())'
        );
        $stmt->execute([
            ':name' => $this->name,
            ':photos' => json_encode($this->photos),
            ':price' => $this->price,
            ':description' => $this->description,
            ':quantity' => $this->quantity,
            ':cat' => $this->category_id
        ]);
        $this->id = (int)$pdo->lastInsertId();
        return $this;
    }

    public function update(): bool {
        $pdo = self::getPDO();
        $stmt = $pdo->prepare('UPDATE product SET quantity=:q, updatedAt=NOW() WHERE id=:id');
        return $stmt->execute([':q'=>$this->quantity, ':id'=>$this->id]);
    }

    public static function findOneById(int $id): self|false { /* ... */ }
    public static function findAll(): array { /* ... */ }
}
