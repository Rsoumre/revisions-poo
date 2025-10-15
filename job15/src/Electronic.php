<?php
namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;

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
        return new self($id, "Laptop", 5, 1000, "TechBrand");
    }

    public static function findAll(): array
    {
        return [
            new self(1, "Laptop", 5, 1000, "TechBrand"),
            new self(2, "Smartphone", 15, 500, "PhoneBrand"),
        ];
    }

    public function create(): self|false { return $this; }
    public function update(): bool { return true; }
}
