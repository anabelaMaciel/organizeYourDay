<?php

namespace App\Entity;

use App\Repository\HorarioMateriaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Bloque semanal de una materia: se usa para armar la grilla de horarios (lunes a sábado)
#[ORM\Entity(repositoryClass: HorarioMateriaRepository::class)]
class HorarioMateria
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Día de la semana: 'lunes' | 'martes' | 'miercoles' | 'jueves' | 'viernes' | 'sabado'
    #[ORM\Column(length: 20)]
    private ?string $day = null;

    // Hora de inicio de la clase
    #[ORM\Column(type: 'time_immutable')]
    private ?\DateTimeImmutable $startTime = null;

    // Hora de fin de la clase
    #[ORM\Column(type: 'time_immutable')]
    private ?\DateTimeImmutable $endTime = null;

    // Aula o salón donde se dicta ("Aula 12", "Lab 3", "Virtual")
    #[ORM\Column(length: 100)]
    private ?string $classroom = null;

    // Materia a la que pertenece este horario
    #[ORM\ManyToOne(targetEntity: Materia::class, inversedBy: 'horarios')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materia $materia = null;

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

    public function getClassroom(): ?string
    {
        return $this->classroom;
    }

    public function setClassroom(string $classroom): static
    {
        $this->classroom = $classroom;

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
        return ($this->day ?? '') . ' ' . ($this->startTime?->format('H:i') ?? '');
    }
}
