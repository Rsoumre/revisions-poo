<?php
namespace App;

use App\Abstract\AbstractProduct;
use App\Interface\StockableInterface;

// Classe représentant les vêtements
class Clothing extends AbstractProduct implements StockableInterface
{
    private string $size;
    private string $color;

    public function __construct(
        int $id = 0,
        string $name = '',
        int $quantity = 0,
        int $price = 0,
        string $size = '',
        string $color = ''
    ) {
        parent::__construct($id, $name, $quantity, $price);
        $this->size = $size;
        $this->color = $color;
    }

    public function getSize(): string { return $this->size; }
    public function getColor(): string { return $this->color; }

    // -----------------------------
    // Implémentation de StockableInterface
    // -----------------------------
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

    // Méthodes abstraites simplifiées pour l'exemple
    public static function findOneById(int $id): self|false
    {
        return new self($id, "T-shirt", 10, 20, "M", "Noir");
    }

    public static function findAll(): array
    {
        return [
            new self(1, "T-shirt", 10, 20, "M", "Noir"),
            new self(2, "Pantalon", 5, 40, "L", "Bleu"),
        ];
    }

    public function create(): self|false
    {
        // Ici tu mettrais le code pour créer en DB
        return $this;
    }

    public function update(): bool
    {
        // Ici tu mettrais le code pour mettre à jour en DB
        return true;
    }
}
