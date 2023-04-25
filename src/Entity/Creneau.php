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





    #[ORM\ManyToOne(inversedBy: 'creneau_cours')]
    private ?Cours $appartient_cours = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_debut_cours = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_fin_cours = null;


    #[ORM\Column]
    private ?bool $all_day = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateDebutCours(): ?\DateTimeInterface
    {
        return $this->date_debut_cours;
    }

    public function setDateDebutCours(\DateTimeInterface $date_debut_cours): self
    {
        $this->date_debut_cours = $date_debut_cours;

        return $this;
    }

    public function getDateFinCours(): ?\DateTimeInterface
    {
        return $this->date_fin_cours;
    }

    public function setDateFinCours(\DateTimeInterface $date_fin_cours): self
    {
        $this->date_fin_cours = $date_fin_cours;

        return $this;
    }

    public function isAllDay(): ?bool
    {
        return $this->all_day;
    }

    public function setAllDay(bool $all_day): self
    {
        $this->all_day = $all_day;

        return $this;
    }

}
