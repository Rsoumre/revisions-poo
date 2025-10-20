<?php
namespace App\Abstract;

use PDO;
use DateTime;

// Classe abstraite qui contient les propriétés et méthodes communes à tous les produits
abstract class AbstractProduct
{
    protected int $id;
    protected string $name;
    protected int $quantity;
    protected int $price;

    public function __construct(
        int $id = 0,
        string $name = '',
        int $quantity = 0,
        int $price = 0
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->quantity = $quantity;
        $this->price = $price;
    }

    // Getters / Setters
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getQuantity(): int { return $this->quantity; }
    public function getPrice(): int { return $this->price; }

    public function setQuantity(int $quantity): self { $this->quantity = $quantity; return $this; }

    /**
     * Hydrate les propriétés communes depuis un tableau associatif (row DB)
     */
    protected function hydrate(array $row): void
    {
        if (isset($row['id'])) $this->id = (int)$row['id'];
        if (isset($row['name'])) $this->name = (string)$row['name'];
        if (isset($row['quantity'])) $this->quantity = (int)$row['quantity'];
        if (isset($row['price'])) $this->price = (int)$row['price'];
    }

    // Méthodes abstraites à implémenter dans les classes enfants
    abstract public static function findOneById(int $id): self|false;
    abstract public static function findAll(): array;
    abstract public function create(): self|false;
    abstract public function update(): bool;
}
