<?php

namespace App\Entity;

use App\Repository\RecipeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RecipeRepository::class)]
class Recipe
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //on ajoute les contraintes liées à la validation du formulaire lié à cette entité
    //il faudra que je précise ces contraintes au-dessus de la colonne visée (ici c'est sur le titre)
    //la contrainte de notBlank qui oblige à mettre une info dans le champs
    #[Assert\NotBlank]
    //contrainte de longueur de champs avec les messages associés
    #[Assert\Length(
        min: 5,
        max: 20,
        minMessage: 'taille minimum nécessaire : 5 caractères',
        maxMessage: 'taille maximale autorisée : 20 caractères'
    )]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    //je rajoute une contrainte notBlank
    #[Assert\NotBlank (message:'Ce champs ne peut pas être nul')]
    #[ORM\Column(length: 255)]
    private ?string $ingredients = null;

    #[Assert\NotBlank (message:'Ce champs ne peut pas être nul')]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $instructions = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'recipes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    //je rajoute une contrainte notBlank
    #[ORM\Column]
    private ?bool $isPublished = null;

    //à la construction d'une nouvelle instance je set 'createdAt'
    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->ingredients;
    }

    public function setIngredients(string $ingredients): static
    {
        $this->ingredients = $ingredients;

        return $this;
    }

    public function getInstructions(): ?string
    {
        return $this->instructions;
    }

    public function setInstructions(string $instructions): static
    {
        $this->instructions = $instructions;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }
}
