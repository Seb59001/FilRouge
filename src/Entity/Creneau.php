<?php

namespace App\Entity;

use App\Repository\CreneauRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreneauRepository::class)]
class Creneau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelle_jour = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_debut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $heure_fin = null;

    #[ORM\Column]
    private ?int $numero_semaine = null;


    #[ORM\ManyToOne(inversedBy: 'creneau_cours')]
    private ?Cours $appartient_cours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleJour(): ?string
    {
        return $this->libelle_jour;
    }

    public function setLibelleJour(string $libelle_jour): self
    {
        $this->libelle_jour = $libelle_jour;

        return $this;
    }

    public function getHeureDebut(): ?\DateTimeInterface
    {
        return $this->heure_debut;
    }

    public function setHeureDebut(\DateTimeInterface $heure_debut): self
    {
        $this->heure_debut = $heure_debut;

        return $this;
    }

    public function getHeureFin(): ?\DateTimeInterface
    {
        return $this->heure_fin;
    }

    public function setHeureFin(\DateTimeInterface $heure_fin): self
    {
        $this->heure_fin = $heure_fin;

        return $this;
    }

    public function getNumeroSemaine(): ?int
    {
        return $this->numero_semaine;
    }

    public function setNumeroSemaine(int $numero_semaine): self
    {
        $this->numero_semaine = $numero_semaine;

        return $this;
    }

    public function getAppartientCours(): ?Cours
    {
        return $this->appartient_cours;
    }

    public function setAppartientCours(?Cours $appartient_cours): self
    {
        $this->appartient_cours = $appartient_cours;

        return $this;
    }
}
