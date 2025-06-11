<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Formateur;
use App\Entity\PeriodeEntreprise;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Formateur::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Formateur $formateur = null;

    #[ORM\Column(type: 'boolean')]
    private bool $actif = true;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column(length: 150)]
    private ?string $nom = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $numero = null;

    #[ORM\Column(length: 30)]
    private ?string $etat = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $titrePro = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $niveau = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $nbStagiairesPrevision = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $groupeRattachement = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'formation', targetEntity: PeriodeEntreprise::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $periodeEntreprises;

    public function __construct()
    {
        $this->periodeEntreprises = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): static
    {
        $this->formateur = $formateur;
        return $this;
    }

    public function isActif(): bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): static
    {
        $this->actif = $actif;
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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): static
    {
        $this->numero = $numero;
        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;
        return $this;
    }

    public function getTitrePro(): ?string
    {
        return $this->titrePro;
    }

    public function setTitrePro(?string $titrePro): static
    {
        $this->titrePro = $titrePro;
        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(?string $niveau): static
    {
        $this->niveau = $niveau;
        return $this;
    }

    public function getNbStagiairesPrevision(): ?string
    {
        return $this->nbStagiairesPrevision;
    }

    public function setNbStagiairesPrevision(?string $nbStagiairesPrevision): static
    {
        $this->nbStagiairesPrevision = $nbStagiairesPrevision;
        return $this;
    }

    public function getGroupeRattachement(): ?string
    {
        return $this->groupeRattachement;
    }

    public function setGroupeRattachement(?string $groupeRattachement): static
    {
        $this->groupeRattachement = $groupeRattachement;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /** @return Collection<int, PeriodeEntreprise> */
    public function getPeriodeEntreprises(): Collection
    {
        return $this->periodeEntreprises;
    }

    public function addPeriodeEntreprise(PeriodeEntreprise $periode): static
    {
        if (!$this->periodeEntreprises->contains($periode)) {
            $this->periodeEntreprises[] = $periode;
            $periode->setFormation($this);
        }

        return $this;
    }

    public function removePeriodeEntreprise(PeriodeEntreprise $periode): static
    {
        if ($this->periodeEntreprises->removeElement($periode)) {
            if ($periode->getFormation() === $this) {
                $periode->setFormation(null);
            }
        }

        return $this;
    }
}
