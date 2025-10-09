<?php

// Déclaration de la classe Product
// Elle permet de représenter un produit dans une boutique (ex : t-shirt, téléphone, etc.)
class Product
{
    // --- 🔒 Propriétés privées ---
    // Elles ne sont accessibles que depuis l'intérieur de la classe
    private int $id;                 // Identifiant unique du produit
    private string $name;            // Nom du produit
    private array $photos;           // Tableau contenant les URLs ou noms des images
    private int $price;              // Prix du produit (en centimes ou en euros)
    private string $description;     // Description du produit
    private int $quantity;           // Quantité en stock
    private DateTime $createdAt;     // Date de création du produit
    private DateTime $updatedAt;     // Date de dernière mise à jour du produit

    // --- 🧩 Constructeur ---
    // Il est appelé automatiquement quand on crée un nouvel objet Product
    // Il sert à initialiser toutes les propriétés de la classe
    public function __construct(
        int $id,
        string $name,
        array $photos,
        int $price,
        string $description,
        int $quantity,
        DateTime $createdAt,
        DateTime $updatedAt
    ) {
        // Le mot-clé $this désigne l’objet en cours
        $this->id = $id;
        $this->name = $name;
        $this->photos = $photos;
        $this->price = $price;
        $this->description = $description;
        $this->quantity = $quantity;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    // --- 📤 Getters ---
    // Ces méthodes permettent d’accéder aux propriétés privées depuis l’extérieur
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getPhotos(): array { return $this->photos; }
    public function getPrice(): int { return $this->price; }
    public function getDescription(): string { return $this->description; }
    public function getQuantity(): int { return $this->quantity; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function getUpdatedAt(): DateTime { return $this->updatedAt; }

    // --- ✏️ Setters ---
    // Ces méthodes permettent de modifier les propriétés privées depuis l’extérieur
    public function setId(int $id): void { $this->id = $id; }
    public function setName(string $name): void { $this->name = $name; }
    public function setPhotos(array $photos): void { $this->photos = $photos; }
    public function setPrice(int $price): void { $this->price = $price; }
    public function setDescription(string $description): void { $this->description = $description; }
    public function setQuantity(int $quantity): void { $this->quantity = $quantity; }
    public function setCreatedAt(DateTime $createdAt): void { $this->createdAt = $createdAt; }
    public function setUpdatedAt(DateTime $updatedAt): void { $this->updatedAt = $updatedAt; }
}
