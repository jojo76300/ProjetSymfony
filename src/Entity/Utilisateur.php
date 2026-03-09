<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $mdp = null;

    #[ORM\Column]
    private ?bool $status = null;

    /**
     * @var Collection<int, Avoir>
     */
    #[ORM\OneToMany(targetEntity: Avoir::class, mappedBy: 'utilisateur')]
    private Collection $avoirs;

    public function __construct()
    {
        $this->avoirs = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getMdp(): ?string
    {
        return $this->mdp;
    }

    public function setMdp(string $mdp): static
    {
        $this->mdp = $mdp;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Avoir>
     */
    public function getAvoirs(): Collection
    {
        return $this->avoirs;
    }

    public function addAvoir(Avoir $avoir): static
    {
        if (!$this->avoirs->contains($avoir)) {
            $this->avoirs->add($avoir);
            $avoir->setUtilisateur($this);
        }

        return $this;
    }

    public function removeAvoir(Avoir $avoir): static
    {
        if ($this->avoirs->removeElement($avoir)) {
            // set the owning side to null (unless already changed)
            if ($avoir->getUtilisateur() === $this) {
                $avoir->setUtilisateur(null);
            }
        }

        return $this;
    }
}
