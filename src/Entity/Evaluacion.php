<?php

namespace App\Entity;

use App\Repository\EvaluacionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Examen de una materia: la nota (grade) alimenta el promedio que se muestra en la card de materia
#[ORM\Entity(repositoryClass: EvaluacionRepository::class)]
class Evaluacion
{
    // Tipos de evaluación disponibles
    public const TYPE_PARCIAL        = 'parcial';
    public const TYPE_FINAL          = 'final';
    public const TYPE_RECUPERATORIO  = 'recuperatorio';
    public const TYPE_COLOQUIO       = 'coloquio';

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Tipo de evaluación: parcial | final | recuperatorio | coloquio
    #[ORM\Column(length: 20)]
    private ?string $type = null;

    // Fecha en que se rinde el examen
    #[ORM\Column(type: 'date_immutable')]
    private ?\DateTimeImmutable $date = null;

    // Nota obtenida (null hasta que se cargue el resultado, ej: 7.5)
    #[ORM\Column(nullable: true)]
    private ?float $grade = null;

    // Observaciones post-examen ("Entrar con calculadora", "Recupero el 15/07")
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    // Materia a la que pertenece este examen
    #[ORM\ManyToOne(targetEntity: Materia::class, inversedBy: 'evaluaciones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Materia $materia = null;

    public function getId(): ?Uuid
    {
        return $this->id;
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

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getGrade(): ?float
    {
        return $this->grade;
    }

    public function setGrade(?float $grade): static
    {
        $this->grade = $grade;

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
        return ($this->type ?? '') . ' — ' . ($this->date?->format('d/m/Y') ?? '');
    }
}
