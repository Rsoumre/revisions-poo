<?php
require_once 'product.php';

class Electronic extends Product {
    private string $brand;
    private int $warranty_fee;

    public function create(): bool {
        if (!parent::create()) return false;

        $stmt = self::$conn->prepare(
            "INSERT INTO electronic (product_id, brand, warranty_fee) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("isi", $this->id, $this->brand, $this->warranty_fee);
        return $stmt->execute();
    }

    public static function findOneById(int $id): self|false {
        $conn = new self();
        $stmt = self::$conn->prepare(
            "SELECT p.*, e.brand, e.warranty_fee 
             FROM product p
             JOIN electronic e ON p.id = e.product_id
             WHERE p.id = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        if ($row) {
            $e = new self();
            $e->hydrate($row);
            $e->brand = $row['brand'];
            $e->warranty_fee = $row['warranty_fee'];
            return $e;
        }
        return false;
    }

    public static function findAll(): array {
        $result = self::$conn->query(
            "SELECT p.*, e.brand, e.warranty_fee 
             FROM product p 
             JOIN electronic e ON p.id = e.product_id"
        );

        $electronics = [];
        while ($row = $result->fetch_assoc()) {
            $e = new self();
            $e->hydrate($row);
            $e->brand = $row['brand'];
            $e->warranty_fee = $row['warranty_fee'];
            $electronics[] = $e;
        }
        return $electronics;
    }

    public function update(): bool {
        if (!parent::update()) return false;

        $stmt = self::$conn->prepare(
            "UPDATE electronic SET brand=?, warranty_fee=? WHERE product_id=?"
        );
        $stmt->bind_param("sii", $this->brand, $this->warranty_fee, $this->id);
        return $stmt->execute();
    }

    // === Setters ===
    public function setBrand($b) { $this->brand = $b; }
    public function setWarrantyFee($w) { $this->warranty_fee = $w; }
}
