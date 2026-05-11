<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Exemple : 'Administrateur', 'Professeur'
    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    // Optionnel : libellé Symfony (ROLE_ADMIN)
    #[ORM\Column(length: 50)]
    private string $libelleSymfony = 'ROLE_USER';

    /**
     * @var Collection<int, Avoir>
     */
    #[ORM\OneToMany(mappedBy: 'role', targetEntity: Avoir::class)]
    private Collection $liensUtilisateurs;

    public function __construct()
    {
        $this->liensUtilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getLibelleSymfony(): string
    {
        return $this->libelleSymfony;
    }

    public function setLibelleSymfony(string $libelleSymfony): static
    {
        $this->libelleSymfony = $libelleSymfony;
        return $this;
    }

    /**
     * @return Collection<int, Avoir>
     */
    public function getLiensUtilisateurs(): Collection
    {
        return $this->liensUtilisateurs;
    }

    public function addLienUtilisateur(Avoir $lien): static
    {
        if (!$this->liensUtilisateurs->contains($lien)) {
            $this->liensUtilisateurs->add($lien);
            $lien->setRole($this);
        }
        return $this;
    }

    public function removeLienUtilisateur(Avoir $lien): static
    {
        if ($this->liensUtilisateurs->removeElement($lien)) {
            if ($lien->getRole() === $this) {
                $lien->setRole(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle ?? '';
    }
}
