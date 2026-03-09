<?php

namespace App\Entity;

use App\Repository\DudaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Repositorio de dudas técnicas del trabajo: bloc de notas con estado resuelto/sin resolver
#[ORM\Entity(repositoryClass: DudaRepository::class)]
class Duda
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Título corto de la duda o problema ("¿Cómo conectar la API de pagos?")
    #[ORM\Column(length: 200)]
    private ?string $title = null;

    // Descripción detallada del problema o pregunta
    #[ORM\Column(type: 'text')]
    private ?string $content = null;

    // Captura de pantalla o imagen adjunta (ruta relativa al servidor)
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    // Fecha en que se registró la duda
    #[ORM\Column(type: 'date_immutable')]
    private ?\DateTimeImmutable $date = null;

    // Estado: false = sin resolver (rojo), true = resuelta (verde)
    #[ORM\Column]
    private bool $resolved = false;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

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

    public function isResolved(): bool
    {
        return $this->resolved;
    }

    public function setResolved(bool $resolved): static
    {
        $this->resolved = $resolved;

        return $this;
    }

    public function __toString(): string
    {
        return $this->title ?? '';
    }
}
