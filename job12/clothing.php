<?php
require_once 'product.php';

class Clothing extends Product {
    private string $size;
    private string $color;
    private string $type;
    private int $material_fee;

    public function create(): bool {
        if (!parent::create()) return false;

        $stmt = self::$conn->prepare(
            "INSERT INTO clothing (product_id, size, color, type, material_fee) VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("isssi", $this->id, $this->size, $this->color, $this->type, $this->material_fee);
        return $stmt->execute();
    }

    public static function findOneById(int $id): self|false {
        $conn = new self();
        $stmt = self::$conn->prepare(
            "SELECT p.*, c.size, c.color, c.type, c.material_fee
             FROM product p
             JOIN clothing c ON p.id = c.product_id
             WHERE p.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if ($row) {
            $c = new self();
            $c->hydrate($row);
            $c->size = $row['size'];
            $c->color = $row['color'];
            $c->type = $row['type'];
            $c->material_fee = $row['material_fee'];
            return $c;
        }
        return false;
    }

    public static function findAll(): array {
        $result = self::$conn->query(
            "SELECT p.*, c.size, c.color, c.type, c.material_fee 
             FROM product p 
             JOIN clothing c ON p.id = c.product_id"
        );

        $clothes = [];
        while ($row = $result->fetch_assoc()) {
            $c = new self();
            $c->hydrate($row);
            $c->size = $row['size'];
            $c->color = $row['color'];
            $c->type = $row['type'];
            $c->material_fee = $row['material_fee'];
            $clothes[] = $c;
        }
        return $clothes;
    }

    public function update(): bool {
        if (!parent::update()) return false;

        $stmt = self::$conn->prepare(
            "UPDATE clothing SET size=?, color=?, type=?, material_fee=? WHERE product_id=?"
        );
        $stmt->bind_param("sssii", $this->size, $this->color, $this->type, $this->material_fee, $this->id);
        return $stmt->execute();
    }

    // === Setters ===
    public function setSize($s) { $this->size = $s; }
    public function setColor($c) { $this->color = $c; }
    public function setType($t) { $this->type = $t; }
    public function setMaterialFee($m) { $this->material_fee = $m; }
}
