<?php

namespace App\Entity;

use App\Repository\ProveedorRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Proveedor de insumos: tabla con contacto rápido (WhatsApp / copiar contacto)
#[ORM\Entity(repositoryClass: ProveedorRepository::class)]
class Proveedor
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Nombre del proveedor o empresa ("Filamentos del Sur", "María — telas")
    #[ORM\Column(length: 150)]
    private ?string $name = null;

    // Teléfono o email de contacto (se usa para el botón de WhatsApp en la tabla)
    #[ORM\Column(length: 150)]
    private ?string $contact = null;

    // Qué material/insumo provee ("Filamento PLA", "Hilo de silicona 2mm")
    #[ORM\Column(length: 200)]
    private ?string $materialSupplied = null;

    // Precio de referencia por unidad/kg (null si no se conoce)
    #[ORM\Column(nullable: true)]
    private ?float $referencePrice = null;

    // Observaciones sobre el proveedor ("Solo paga transferencia", "Entrega los jueves")
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

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    public function getMaterialSupplied(): ?string
    {
        return $this->materialSupplied;
    }

    public function setMaterialSupplied(string $materialSupplied): static
    {
        $this->materialSupplied = $materialSupplied;

        return $this;
    }

    public function getReferencePrice(): ?float
    {
        return $this->referencePrice;
    }

    public function setReferencePrice(?float $referencePrice): static
    {
        $this->referencePrice = $referencePrice;

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
