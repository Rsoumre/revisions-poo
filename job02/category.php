<?php

class Category
{
    /** @var int Identifiant */
    private int $id;
    /** @var string Nom */
    private string $name;
    /** @var string Description */
    private string $description;
    /** @var DateTime Date de création */
    private DateTime $createdAt;
    /** @var DateTime Date de dernière mise à jour */
    private DateTime $updatedAt;

    /**
     * Category constructor.
     * Les paramètres ont des valeurs par défaut pour faciliter les tests.
     */
    public function __construct(int $id = 0, string $name = '', string $description = '', ?DateTime $createdAt = null, ?DateTime $updatedAt = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        // Si aucune DateTime fournie, on initialise à maintenant
        $this->createdAt = $createdAt ?? new DateTime();
        $this->updatedAt = $updatedAt ?? new DateTime();
    }

    // -----------------
    // Getters
    // -----------------
    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getDescription(): string { return $this->description; }
    public function getCreatedAt(): DateTime { return $this->createdAt; }
    public function getUpdatedAt(): DateTime { return $this->updatedAt; }

    // -----------------
    // Setters (retournent $this pour permettre le chaining)
    // -----------------
    public function setId(int $id): self { $this->id = $id; return $this; }
    public function setName(string $name): self { $this->name = $name; return $this; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function setCreatedAt(DateTime $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function setUpdatedAt(DateTime $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }
}

// Fin du fichier category.php