<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 38)]
    private ?string $nom = null;

    #[ORM\Column(length: 38)]
    private ?string $prenom = null;

    #[ORM\Column(length: 100)]
    private ?string $filiere = null;


    #[ORM\Column(name: 'is_archived', type: 'boolean')]
    private bool $isArchived = false;

    #[ORM\ManyToOne(inversedBy: 'etudiants')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Promotion $promotion = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getFiliere(): ?string
    {
        return $this->filiere;
    }

    public function setFiliere(string $filiere): static
    {
        $this->filiere = $filiere;
        return $this;
    }

    public function isArchived(): bool
    {
        return $this->isArchived;
    }

    public function setIsArchived(bool $isArchived): static
    {
        $this->isArchived = $isArchived;
        return $this;
    }

    public function __toString(): string
    {
        return trim($this->prenom.' '.$this->nom);
    }

    public function getPromotion(): ?Promotion
    {
        return $this->promotion;
    }
    
    public function setPromotion(?Promotion $promotion): static
    {
        $this->promotion = $promotion;
        return $this;
    }

}
