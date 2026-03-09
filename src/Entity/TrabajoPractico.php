<?php

namespace App\Entity;

use App\Repository\TrabajoPracticoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// TP de una materia: se lista con estado visual y alerta de proximidad (< 3 días → melocotón)
#[ORM\Entity(repositoryClass: TrabajoPracticoRepository::class)]
class TrabajoPractico
{
    // Estados posibles del TP
    public const STATUS_PENDIENTE   = 'pendiente';
    public const STATUS_EN_PROGRESO = 'en_progreso';
    public const STATUS_ENTREGADO   = 'entregado';
    public const STATUS_VENCIDO     = 'vencido';

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Título del TP ("TP N°3 — Normalización", "Proyecto final")
    #[ORM\Column(length: 200)]
    private ?string $title = null;

    // Consigna o descripción ampliada (opcional)
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    // Fecha límite de entrega — si ya pasó y no está entregado → vencido
    #[ORM\Column(type: 'date_immutable')]
    private ?\DateTimeImmutable $dueDate = null;

    // Estado actual: pendiente | en_progreso | entregado | vencido
    #[ORM\Column(length: 20)]
    private ?string $status = self::STATUS_PENDIENTE;

    // Materia a la que pertenece este TP
    #[ORM\ManyToOne(targetEntity: Materia::class, inversedBy: 'trabajosPracticos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materia $materia = null;

    public function getId(): ?Uuid
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDueDate(): ?\DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeImmutable $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getMateria(): ?Materia
    {
        return $this->materia;
    }

    public function setMateria(?Materia $materia): static
    {
        $this->materia = $materia;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? '';
    }
}
