<?php

namespace App\Entity;

use App\Repository\DayNoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Nota libre del día: aparece en la card del día en el carrusel del dashboard
#[ORM\Entity(repositoryClass: DayNoteRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_DAY_NOTE_DATE_USER', fields: ['date', 'user'])]
class DayNote
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Fecha del día al que corresponde la nota (una nota por día por usuario)
    #[ORM\Column(type: 'date_immutable')]
    private ?\DateTimeImmutable $date = null;

    // Contenido libre de la nota ("Estudiar antes de cursar", recordatorios, etc.)
    #[ORM\Column(type: 'text')]
    private ?string $content = null;

    // Usuaria dueña de la nota
    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'dayNotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function __toString(): string
    {
        return $this->date?->format('d/m/Y') ?? '';
    }
}
