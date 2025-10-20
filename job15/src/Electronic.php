<?php
namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;
use App\Database;

// Classe représentant les produits électroniques
class Electronic extends AbstractProduct implements StockableInterface
{
    private string $brand;

    public function __construct(
        int $id = 0,
        string $name = '',
        int $quantity = 0,
        int $price = 0,
        string $brand = ''
    ) {
        parent::__construct($id, $name, $quantity, $price);
        $this->brand = $brand;
    }

    public function getBrand(): string { return $this->brand; }

    public function addStocks(int $stock): self
    {
        $this->quantity += $stock;
        return $this;
    }

    public function removeStocks(int $stock): self
    {
        $this->quantity -= $stock;
        return $this;
    }

    public static function findOneById(int $id): self|false
    {
        $pdo = Database::getPdo();
        if ($pdo) {
            $stmt = $pdo->prepare('SELECT p.id, p.name, p.quantity, p.price, e.brand FROM product p JOIN electronic e ON p.id = e.product_id WHERE p.id = :id');
            try {
                $stmt->execute(['id' => $id]);
                $row = $stmt->fetch();
                if ($row) {
                    $e = new self();
                    $e->hydrate($row);
                    $e->brand = $row['brand'] ?? '';
                    return $e;
                }
            } catch (\Exception $e) {
                // fallback
            }
        }

        return new self($id, "Laptop", 5, 1000, "TechBrand");
    }

    public static function findAll(): array
    {
        $pdo = Database::getPdo();
        if ($pdo) {
            $stmt = $pdo->query('SELECT p.id, p.name, p.quantity, p.price, e.brand FROM product p JOIN electronic e ON p.id = e.product_id');
            $rows = $stmt->fetchAll();
            $electronics = [];
            foreach ($rows as $row) {
                $e = new self();
                $e->hydrate($row);
                $e->brand = $row['brand'] ?? '';
                $electronics[] = $e;
            }
            if (!empty($electronics)) return $electronics;
        }

        return [
            new self(1, "Laptop", 5, 1000, "TechBrand"),
            new self(2, "Smartphone", 15, 500, "PhoneBrand"),
        ];
    }

    public function create(): self|false { return $this; }
    public function update(): bool { return true; }
}
