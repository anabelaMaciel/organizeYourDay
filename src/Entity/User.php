<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidGenerator;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

// Entidad de seguridad: perfil único de la usuaria y credenciales de acceso
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    private ?Uuid $id = null;

    // Email usado para iniciar sesión (identificador único)
    #[ORM\Column(length: 180)]
    private ?string $email = null;

    // Roles de seguridad: ['ROLE_USER'] por defecto, ['ROLE_ADMIN'] para EasyAdmin
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    // Contraseña hasheada con bcrypt/argon2i — nunca almacenar en texto plano
    #[ORM\Column]
    private ?string $password = null;

    // Nombre visible en el saludo del dashboard ("Buen día, Valentina ☀️")
    #[ORM\Column(length: 100)]
    private ?string $name = null;

    // Ruta relativa a la foto de perfil subida al servidor
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    // Biografía corta visible en la pantalla Mi Perfil
    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $bio = null;

    // Frase personalizada que aparece en el dashboard al arrancar el día
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $welcomeMessage = null;

    // Notas diarias asociadas a esta usuaria
    #[ORM\OneToMany(targetEntity: DayNote::class, mappedBy: 'user', orphanRemoval: true)]
    private Collection $dayNotes;

    public function __construct()
    {
        $this->dayNotes = new ArrayCollection();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    // Identificador único usado por Symfony Security (el email en este caso)
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // Garantiza que todo usuario tenga al menos ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    // Limpia datos sensibles temporales de memoria (no aplica con hashing moderno)
    public function eraseCredentials(): void
    {
        // Si almacenáramos una contraseña en texto plano temporalmente, la borraríamos aquí
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

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): static
    {
        $this->photo = $photo;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->bio;
    }

    public function setBio(?string $bio): static
    {
        $this->bio = $bio;

        return $this;
    }

    public function getWelcomeMessage(): ?string
    {
        return $this->welcomeMessage;
    }

    public function setWelcomeMessage(?string $welcomeMessage): static
    {
        $this->welcomeMessage = $welcomeMessage;

        return $this;
    }

    /**
     * @return Collection<int, DayNote>
     */
    public function getDayNotes(): Collection
    {
        return $this->dayNotes;
    }

    public function addDayNote(DayNote $dayNote): static
    {
        if (!$this->dayNotes->contains($dayNote)) {
            $this->dayNotes->add($dayNote);
            $dayNote->setUser($this);
        }

        return $this;
    }

    public function removeDayNote(DayNote $dayNote): static
    {
        if ($this->dayNotes->removeElement($dayNote)) {
            if ($dayNote->getUser() === $this) {
                $dayNote->setUser(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name ?? $this->email ?? '';
    }
}
