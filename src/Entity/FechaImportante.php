<?php

namespace App\Entity;

use App\Repository\FechaImportanteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Fechas clave del calendario académico: se muestran en timeline vertical en el módulo Facultad
#[ORM\Entity(repositoryClass: FechaImportanteRepository::class)]
class FechaImportante
{
    // Tipos de fecha institucional disponibles
    public const TYPE_INSCRIPCION    = 'inscripcion';
    public const TYPE_INICIO_CURSADA = 'inicio_cursada';
    public const TYPE_FIN_CURSADA    = 'fin_cursada';
    public const TYPE_ENTREGA        = 'entrega';
    public const TYPE_OTRO           = 'otro';

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Título de la fecha ("Inicio de inscripciones", "Último día de cursada")
    #[ORM\Column(length: 200)]
    private ?string $title = null;

    // Fecha del evento institucional
    #[ORM\Column(type: 'date_immutable')]
    private ?\DateTimeImmutable $date = null;

    // Tipo: inscripcion | inicio_cursada | fin_cursada | entrega | otro
    #[ORM\Column(length: 30)]
    private ?string $type = self::TYPE_OTRO;

    // Detalle adicional (link a SIU, instrucciones, etc.)
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

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

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

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

    public function __toString(): string
    {
        return $this->title ?? '';
    }
}
