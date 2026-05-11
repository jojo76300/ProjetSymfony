<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column(name: 'mdp', length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: 'boolean')]
    private bool $status = true;

    #[ORM\OneToMany(mappedBy: 'utilisateur', targetEntity: Avoir::class, cascade: ['persist', 'remove'])]
    private Collection $liensRoles;

    public function __construct()
    {
        $this->liensRoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getUsername(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = [];

        foreach ($this->liensRoles as $avoir) {
            $role = $avoir->getRole();
            if ($role) {
                $roles[] = $role->getLibelleSymfony();
            }
        }

        $roles[] = 'ROLE_USER';

        return array_values(array_unique($roles));
    }

    public function eraseCredentials(): void
    {
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

    public function isStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getLiensRoles(): Collection
    {
        return $this->liensRoles;
    }

    public function addLienRole(Avoir $lien): static
    {
        if (!$this->liensRoles->contains($lien)) {
            $this->liensRoles->add($lien);
            $lien->setUtilisateur($this);
        }
        return $this;
    }

    public function removeLienRole(Avoir $lien): static
    {
        if ($this->liensRoles->removeElement($lien)) {
            if ($lien->getUtilisateur() === $this) {
                $lien->setUtilisateur(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        if ($this->nom || $this->prenom) {
            return trim(($this->prenom ?? '').' '.($this->nom ?? ''));
        }

        return (string) $this->email;
    }
}