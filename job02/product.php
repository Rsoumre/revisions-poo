<?php
/**
 * Class Product
 * Représente un produit de la boutique.
 *
 * Nouvelle propriété pour Job02 : category_id (nullable int) qui référence l'id d'une Category.
 */
class Product
{
    private int $id;
    private string $name;
    private array $photos;
    private int $price;
    private string $description;
    private int $quantity;
    /** @var int|null ID de la catégorie (si connue) */
    private ?int $category_id;
    private DateTime $createdAt;
    private DateTime $updatedAt;

    /**
     * Product constructor.
     * Les paramètres ont des valeurs par défaut pour faciliter les tests sans devoir tout fournir.
     * @param int $id
     * @param string $name
     * @param array $photos
     * @param int $price Prix en centimes
     * @param string $description
     * @param int $quantity
     * @param int|null $category_id
     * @param DateTime|null $createdAt
     * @param DateTime|null $updatedAt
     */
    public function __construct(
        int $id = 0,
        string $name = '',
        array $photos = [],
        int $price = 0,
        string $description = '',
        int $quantity = 0,
        ?int $category_id = null,
        ?DateTime $createdAt = null,
        ?DateTime $updatedAt = null
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        // category_id peut être null si le produit n'est pas encore affecté à une catégorie
        $this->category_id = $category_id;
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
    }

    // -----------------
    // Getters
    // -----------------
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPhotos(): array { return $this->photos; }
    public function getPrice(): int { return $this->price; }
    public function getDescription(): string { return $this->description; }
    public function getQuantity(): int { return $this->quantity; }
    public function getCategoryId(): ?int { return $this->category_id; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function getUpdatedAt(): DateTime { return $this->updatedAt; }

    // -----------------
    // Setters
    // -----------------
    public function setId(int $id): self { $this->id = $id; return $this; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function setPhotos(array $photos): self { $this->photos = $photos; return $this; }
    public function setPrice(int $price): self { $this->price = $price; return $this; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function setQuantity(int $quantity): self { $this->quantity = $quantity; return $this; }
    public function setCategoryId(?int $category_id): self { $this->category_id = $category_id; return $this; }
    public function setCreatedAt(DateTime $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function setUpdatedAt(DateTime $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }
}
