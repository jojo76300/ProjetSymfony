<?php

namespace App\Entity;

use App\Repository\VisiteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VisiteRepository::class)]
class Visite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name: 'date_visite', type: 'date')]
    private ?\DateTimeInterface $dateVisite = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $commentaires = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stage $stage = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'enseignant_visiteur_id', nullable: false)]
    private ?Utilisateur $enseignantVisiteur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeInterface $dateVisite): static
    {
        $this->dateVisite = $dateVisite;
        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): static
    {
        $this->commentaires = $commentaires;
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

    public function getEnseignantVisiteur(): ?Utilisateur
    {
        return $this->enseignantVisiteur;
    }

    public function setEnseignantVisiteur(?Utilisateur $enseignantVisiteur): static
    {
        $this->enseignantVisiteur = $enseignantVisiteur;
        return $this;
    }
}
