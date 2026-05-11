<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $classe = null;

    #[ORM\Column(length: 30)]
    private ?string $session = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateDebutStageDefaut = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateFinStageDefaut = null;

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: Etudiant::class)]
    private Collection $etudiants;

    public function __construct()
    {
        $this->etudiants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClasse(): ?string
    {
        return $this->classe;
    }

    public function setClasse(string $classe): static
    {
        $this->classe = $classe;
        return $this;
    }

    public function getSession(): ?string
    {
        return $this->session;
    }

    public function setSession(string $session): static
    {
        $this->session = $session;
        return $this;
    }

    public function getDateDebutStageDefaut(): ?\DateTimeInterface
    {
        return $this->dateDebutStageDefaut;
    }

    public function setDateDebutStageDefaut(\DateTimeInterface $dateDebutStageDefaut): static
    {
        $this->dateDebutStageDefaut = $dateDebutStageDefaut;
        return $this;
    }

    public function getDateFinStageDefaut(): ?\DateTimeInterface
    {
        return $this->dateFinStageDefaut;
    }

    public function setDateFinStageDefaut(\DateTimeInterface $dateFinStageDefaut): static
    {
        $this->dateFinStageDefaut = $dateFinStageDefaut;
        return $this;
    }

    public function getEtudiants(): Collection
    {
        return $this->etudiants;
    }

    public function __toString(): string
    {
        return $this->classe . ' - ' . $this->session;
    }
}