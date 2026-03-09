<?php

namespace App\Entity;

use App\Repository\AlertRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Recordatorio configurable: suena mientras la app esté abierta en el navegador
#[ORM\Entity(repositoryClass: AlertRepository::class)]
class Alert
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Hora del día en que se dispara la alerta ("12:00 — Almuerzo y descanso")
    #[ORM\Column(type: 'time_immutable')]
    private ?\DateTimeImmutable $time = null;

    // Mensaje que aparece en el modal de recordatorio
    #[ORM\Column(length: 255)]
    private ?string $message = null;

    // Días de la semana activos: ['lunes', 'miercoles', 'viernes']
    #[ORM\Column(type: 'json')]
    private array $days = [];

    // Tono de sonido: 'bell' | 'chime' | 'beep'
    #[ORM\Column(length: 20)]
    private ?string $sound = 'bell';

    // Si está desactivada no suena aunque llegue la hora
    #[ORM\Column]
    private bool $active = true;

    // Minutos a posponer cuando la usuaria toca "Posponer 10'" en el modal
    #[ORM\Column]
    private int $snoozeMinutes = 10;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getTime(): ?\DateTimeImmutable
    {
        return $this->time;
    }

    public function setTime(\DateTimeImmutable $time): static
    {
        $this->time = $time;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getDays(): array
    {
        return $this->days;
    }

    public function setDays(array $days): static
    {
        $this->days = $days;

        return $this;
    }

    public function getSound(): ?string
    {
        return $this->sound;
    }

    public function setSound(string $sound): static
    {
        $this->sound = $sound;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getSnoozeMinutes(): int
    {
        return $this->snoozeMinutes;
    }

    public function setSnoozeMinutes(int $snoozeMinutes): static
    {
        $this->snoozeMinutes = $snoozeMinutes;

        return $this;
    }

    public function __toString(): string
    {
        return $this->time?->format('H:i') . ' — ' . ($this->message ?? '');
    }
}
