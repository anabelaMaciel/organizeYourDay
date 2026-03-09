<?php

namespace App\Entity;

use App\Repository\HorarioLaboralRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Registro diario de jornada laboral: horas objetivo vs horas trabajadas (barra de progreso)
#[ORM\Entity(repositoryClass: HorarioLaboralRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_HORARIO_LABORAL_DATE', fields: ['date'])]
class HorarioLaboral
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Fecha del día laboral (único por día)
    #[ORM\Column(type: 'date_immutable', unique: true)]
    private ?\DateTimeImmutable $date = null;

    // Hora de inicio de la jornada ("Iniciar jornada")
    #[ORM\Column(type: 'time_immutable')]
    private ?\DateTimeImmutable $startTime = null;

    // Hora de fin de la jornada ("Finalizar jornada")
    #[ORM\Column(type: 'time_immutable')]
    private ?\DateTimeImmutable $endTime = null;

    // Horas que se planificaron trabajar ese día (ej: 6.0)
    #[ORM\Column]
    private ?float $targetHours = null;

    // Horas efectivamente trabajadas — se actualiza durante la jornada (default 0)
    #[ORM\Column]
    private float $workedHours = 0.0;

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getTargetHours(): ?float
    {
        return $this->targetHours;
    }

    public function setTargetHours(float $targetHours): static
    {
        $this->targetHours = $targetHours;

        return $this;
    }

    public function getWorkedHours(): float
    {
        return $this->workedHours;
    }

    public function setWorkedHours(float $workedHours): static
    {
        $this->workedHours = $workedHours;

        return $this;
    }

    public function __toString(): string
    {
        return $this->date?->format('d/m/Y') ?? '';
    }
}
