<?php

namespace App\Entity;

use App\Repository\HorarioEmprendimientoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Bloques de tiempo semanales dedicados al emprendimiento (similar al horario laboral pero fijo por día)
#[ORM\Entity(repositoryClass: HorarioEmprendimientoRepository::class)]
class HorarioEmprendimiento
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Día de la semana asignado al bloque: 'lunes' ... 'domingo'
    #[ORM\Column(length: 20)]
    private ?string $day = null;

    // Hora de inicio del bloque de trabajo en el emprendimiento
    #[ORM\Column(type: 'time_immutable')]
    private ?\DateTimeImmutable $startTime = null;

    // Hora de fin del bloque
    #[ORM\Column(type: 'time_immutable')]
    private ?\DateTimeImmutable $endTime = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): static
    {
        $this->day = $day;

        return $this;
    }

    public function getStartTime(): ?\DateTimeImmutable
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTimeImmutable $startTime): static
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getEndTime(): ?\DateTimeImmutable
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeImmutable $endTime): static
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function __toString(): string
    {
        return ($this->day ?? '') . ' ' . ($this->startTime?->format('H:i') ?? '');
    }
}
