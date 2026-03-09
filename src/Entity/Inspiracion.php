<?php

namespace App\Entity;

use App\Repository\InspiracionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Board de inspiración tipo Pinterest/masonry: imágenes de referencia para el emprendimiento
#[ORM\Entity(repositoryClass: InspiracionRepository::class)]
class Inspiracion
{
    // Categorías del board de inspiración
    public const CATEGORY_REFERENCIA_DISENO = 'referencia_diseno';
    public const CATEGORY_MODELO_IMPRIMIR   = 'modelo_imprimir';
    public const CATEGORY_COLOR             = 'color';
    public const CATEGORY_ESTILO            = 'estilo';
    public const CATEGORY_OTRO              = 'otro';

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Ruta relativa de la imagen subida (se muestra en la card del masonry)
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    // Descripción opcional debajo de la imagen ("Referencia para el producto de junio")
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    // Categoría para filtrar en el board: referencia_diseno | modelo_imprimir | color | estilo | otro
    #[ORM\Column(length: 30)]
    private ?string $category = self::CATEGORY_OTRO;

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function __toString(): string
    {
        return $this->description ?? $this->image ?? '';
    }
}
