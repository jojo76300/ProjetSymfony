<?php

namespace App\Entity;

use App\Repository\AffectationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AffectationRepository::class)]
class Affectation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // 'Suivi' ou 'Visite'
    #[ORM\Column(name: 'role_affectation', length: 20)]
    private ?string $roleAffectation = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $stage = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'enseignant_id', nullable: false)]
    private ?Utilisateur $enseignant = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoleAffectation(): ?string
    {
        return $this->roleAffectation;
    }

    public function setRoleAffectation(string $roleAffectation): static
    {
        $this->roleAffectation = $roleAffectation;
        return $this;
    }

    public function getStage(): ?Stage
    {
        return $this->stage;
    }

    public function setStage(?Stage $stage): static
    {
        $this->stage = $stage;
        return $this;
    }

    public function getEnseignant(): ?Utilisateur
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Utilisateur $enseignant): static
    {
        $this->enseignant = $enseignant;
        return $this;
    }
}
