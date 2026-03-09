<?php

namespace App\Entity;

use App\Repository\EntregaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

// Pedido del emprendimiento: lista con estado e indicador de urgencia por fecha de entrega
#[ORM\Entity(repositoryClass: EntregaRepository::class)]
class Entrega
{
    // Estados del ciclo de vida de un pedido
    public const STATUS_PREPARANDO = 'preparando';
    public const STATUS_LISTO      = 'listo';
    public const STATUS_ENVIADO    = 'enviado';
    public const STATUS_ENTREGADO  = 'entregado';

    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Nombre o descripción del producto pedido ("Llavero personalizado x3")
    #[ORM\Column(length: 200)]
    private ?string $product = null;

    // Nombre del cliente o destinatario
    #[ORM\Column(length: 150)]
    private ?string $client = null;

    // Fecha comprometida de entrega — si se acerca → indicador de urgencia
    #[ORM\Column(type: 'date_immutable')]
    private ?\DateTimeImmutable $dueDate = null;

    // Estado del pedido: preparando | listo | enviado | entregado
    #[ORM\Column(length: 20)]
    private ?string $status = self::STATUS_PREPARANDO;

    // Notas internas ("Enviar por Andreani", "El cliente paga al recibir")
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $notes = null;

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getProduct(): ?string
    {
        return $this->product;
    }

    public function setProduct(string $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): static
    {
        $this->client = $client;

        return $this;
    }

    public function getDueDate(): ?\DateTimeImmutable
    {
        return $this->dueDate;
    }

    public function setDueDate(\DateTimeImmutable $dueDate): static
    {
        $this->dueDate = $dueDate;

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

    public function getNotes(): ?string
    {
        return $this->notes;
    }

    public function setNotes(?string $notes): static
    {
        $this->notes = $notes;

        return $this;
    }

    public function __toString(): string
    {
        return ($this->product ?? '') . ' — ' . ($this->client ?? '');
    }
}
