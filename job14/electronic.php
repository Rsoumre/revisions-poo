<?php
require_once 'product.php';
require_once 'StockableInterface.php';

class Electronic extends AbstractProduct implements StockableInterface
{
    private string $brand;

    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        int $price = 0,
        string $description = '',
        int $quantity = 0,
        int $category_id = 2,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null,
        string $brand = ''
    ) {
        parent::__construct($id, $name, $photos, $price, $description, $quantity, $category_id, $createdAt, $updatedAt);
        $this->brand = $brand;
    }

    public function addStocks(int $stock): self { $this->quantity += $stock; return $this; }
    public function removeStocks(int $stock): self { $this->quantity = max(0, $this->quantity - $stock); return $this; }

    public function create(): self|false { /* ... */ }
    public function update(): bool { /* ... */ }
    public static function findOneById(int $id): self|false { /* ... */ }
    public static function findAll(): array { /* ... */ }
}
