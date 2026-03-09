<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Inventario del emprendimiento: stock de insumos con edición rápida inline en la tabla
#[ORM\Entity(repositoryClass: MaterialRepository::class)]
class Material
{
    // Unidades de medida disponibles en el selector
    public const UNIT_KG     = 'kg';
    public const UNIT_G      = 'g';
    public const UNIT_UNIDAD = 'unidad';
    public const UNIT_METRO  = 'metro';
    public const UNIT_LITRO  = 'litro';
    public const UNIT_ROLLO  = 'rollo';
    public const UNIT_OTRO   = 'otro';

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Nombre del insumo ("Filamento PLA", "Hilo de silicona", "Vinilo adhesivo")
    #[ORM\Column(length: 150)]
    private ?string $name = null;

    // Cantidad disponible en stock (puede ser decimal, ej: 1.5 kg)
    #[ORM\Column]
    private ?float $quantity = null;

    // Unidad de medida: kg | g | unidad | metro | litro | rollo | otro
    #[ORM\Column(length: 20)]
    private ?string $unit = self::UNIT_UNIDAD;

    // Observaciones sobre el material ("Comprar más cuando llegue a 0.5 kg")
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
