<?php

namespace App\Entity;

use App\Repository\TareaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Tarea del trabajo: se visualiza en el tablero Kanban (Pendiente / En progreso / Terminado)
#[ORM\Entity(repositoryClass: TareaRepository::class)]
class Tarea
{
    // Columnas del Kanban
    public const STATUS_PENDIENTE   = 'pendiente';
    public const STATUS_EN_PROGRESO = 'en_progreso';
    public const STATUS_TERMINADO   = 'terminado';

    // Niveles de prioridad (color de etiqueta en la card del Kanban)
    public const PRIORITY_ALTA  = 'alta';
    public const PRIORITY_MEDIA = 'media';
    public const PRIORITY_BAJA  = 'baja';

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Título corto que aparece en la card del Kanban
    #[ORM\Column(length: 200)]
    private ?string $title = null;

    // Descripción breve visible en el detalle de la card
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    // Estado actual (define en qué columna del Kanban está)
    #[ORM\Column(length: 20)]
    private ?string $status = self::STATUS_PENDIENTE;

    // Prioridad: alta (rojo) | media (amarillo) | baja (verde)
    #[ORM\Column(length: 10)]
    private ?string $priority = self::PRIORITY_MEDIA;

    // Fecha límite opcional — si se acerca, resaltar en melocotón
    #[ORM\Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $dueDate = null;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getDueDate(): ?\DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function setDueDate(?\DateTimeImmutable $dueDate): static
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? '';
    }
}
