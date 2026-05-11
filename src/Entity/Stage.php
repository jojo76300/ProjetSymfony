<?php

namespace App\Entity;

use App\Repository\StageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StageRepository::class)]
class Stage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etudiant $etudiant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entreprise $entreprise = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'prof_suivi_id', nullable: true)]
    private ?Utilisateur $profSuivi = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'prof_visite_id', nullable: true)]
    private ?Utilisateur $profVisite = null;

    #[ORM\Column(name: 'date_debut', type: 'date')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(name: 'date_fin', type: 'date')]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $remarques = null;

    #[ORM\Column(name: 'statut_attestation', length: 20, options: ['default' => 'Non saisi'])]
    private string $statutAttestation = 'Non saisi';

    // --- NOUVEAUTÉ : La relation vers l'historique ---
    #[ORM\OneToMany(mappedBy: 'stage', targetEntity: Historique::class, cascade: ['remove'])]
    private Collection $historiques;

    // --- NOUVEAUTÉ : Initialisation de la collection ---
    public function __construct()
    {
        $this->historiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;
        return $this;
    }

    public function getEntreprise(): ?Entreprise
    {
        return $this->entreprise;
    }

    public function setEntreprise(?Entreprise $entreprise): static
    {
        $this->entreprise = $entreprise;
        return $this;
    }

    public function getProfSuivi(): ?Utilisateur
    {
        return $this->profSuivi;
    }

    public function setProfSuivi(?Utilisateur $profSuivi): static
    {
        $this->profSuivi = $profSuivi;
        return $this;
    }

    public function getProfVisite(): ?Utilisateur
    {
        return $this->profVisite;
    }

    public function setProfVisite(?Utilisateur $profVisite): static
    {
        $this->profVisite = $profVisite;
        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getRemarques(): ?string
    {
        return $this->remarques;
    }

    public function setRemarques(?string $remarques): static
    {
        $this->remarques = $remarques;
        return $this;
    }

    public function getStatutAttestation(): string
    {
        return $this->statutAttestation;
    }

    public function setStatutAttestation(string $statutAttestation): static
    {
        $this->statutAttestation = $statutAttestation;
        return $this;
    }

    public function getDuree(): ?int
    {
        if (!$this->dateDebut || !$this->dateFin) {
            return null;
        }

        $jours = $this->dateFin->diff($this->dateDebut)->days + 1;
        return round($jours / 7);
    }

    // --- NOUVEAUTÉ : Le Getter pour l'historique ---
    /**
     * @return Collection<int, Historique>
     */
    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }
}