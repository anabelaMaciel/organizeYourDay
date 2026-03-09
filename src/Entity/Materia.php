<?php

namespace App\Entity;

use App\Repository\MateriaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Materia universitaria: núcleo del módulo Facultad
#[ORM\Entity(repositoryClass: MateriaRepository::class)]
class Materia
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Nombre de la materia ("Sistemas I", "Matemática II")
    #[ORM\Column(length: 150)]
    private ?string $name = null;

    // Nombre del docente a cargo
    #[ORM\Column(length: 150)]
    private ?string $teacher = null;

    // Régimen de cursada: 'anual' | 'cuatrimestral' (null = anual por defecto)
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $regime = 'anual';

    // Año lectivo de la materia (2024, 2025...)
    #[ORM\Column]
    private ?int $year = null;

    // Color HEX para identificar la materia en el calendario y sus cards (#F4A5A5)
    #[ORM\Column(length: 7)]
    private ?string $color = '#F4A5A5';

    // Horarios semanales de la materia (cuándo y dónde se cursa)
    #[ORM\OneToMany(targetEntity: HorarioMateria::class, mappedBy: 'materia', orphanRemoval: true)]
    private Collection $horarios;

    // Trabajos prácticos asociados a esta materia
    #[ORM\OneToMany(targetEntity: TrabajoPractico::class, mappedBy: 'materia', orphanRemoval: true)]
    private Collection $trabajosPracticos;

    // Evaluaciones (parciales, finales, recuperatorios) de esta materia
    #[ORM\OneToMany(targetEntity: Evaluacion::class, mappedBy: 'materia', orphanRemoval: true)]
    private Collection $evaluaciones;

    public function __construct()
    {
        $this->horarios = new ArrayCollection();
        $this->trabajosPracticos = new ArrayCollection();
        $this->evaluaciones = new ArrayCollection();
    }

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

    public function getTeacher(): ?string
    {
        return $this->teacher;
    }

    public function setTeacher(string $teacher): static
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getRegime(): ?string
    {
        return $this->regime;
    }

    public function setRegime(?string $regime): static
    {
        $this->regime = $regime;

        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): static
    {
        $this->year = $year;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(string $color): static
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, HorarioMateria>
     */
    public function getHorarios(): Collection
    {
        return $this->horarios;
    }

    public function addHorario(HorarioMateria $horario): static
    {
        if (!$this->horarios->contains($horario)) {
            $this->horarios->add($horario);
            $horario->setMateria($this);
        }

        return $this;
    }

    public function removeHorario(HorarioMateria $horario): static
    {
        if ($this->horarios->removeElement($horario)) {
            if ($horario->getMateria() === $this) {
                $horario->setMateria(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TrabajoPractico>
     */
    public function getTrabajosPracticos(): Collection
    {
        return $this->trabajosPracticos;
    }

    public function addTrabajoPractico(TrabajoPractico $tp): static
    {
        if (!$this->trabajosPracticos->contains($tp)) {
            $this->trabajosPracticos->add($tp);
            $tp->setMateria($this);
        }

        return $this;
    }

    public function removeTrabajoPractico(TrabajoPractico $tp): static
    {
        if ($this->trabajosPracticos->removeElement($tp)) {
            if ($tp->getMateria() === $this) {
                $tp->setMateria(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evaluacion>
     */
    public function getEvaluaciones(): Collection
    {
        return $this->evaluaciones;
    }

    public function addEvaluacion(Evaluacion $evaluacion): static
    {
        if (!$this->evaluaciones->contains($evaluacion)) {
            $this->evaluaciones->add($evaluacion);
            $evaluacion->setMateria($this);
        }

        return $this;
    }

    public function removeEvaluacion(Evaluacion $evaluacion): static
    {
        if ($this->evaluaciones->removeElement($evaluacion)) {
            if ($evaluacion->getMateria() === $this) {
                $evaluacion->setMateria(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
