<?php

namespace App\Entity;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $libelee_cour = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\OneToMany(mappedBy: 'presence_cours', targetEntity: Presence::class)]
    private Collection $presence_cours;

    public function __construct()
    {
        $this->presence_cours = new ArrayCollection();
    }

    


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibeleeCour(): ?string
    {
        return $this->libelee_cour;
    }

    public function setLibeleeCour(string $libelee_cour): self
    {
        $this->libelee_cour = $libelee_cour;

        return $this;
    }

    public function getDateDebut(): ?string
    {
        return $this->date_debut;
    }

    public function setDateDebut(string $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresenceCours(): Collection
    {
        return $this->presence_cours;
    }

    public function addPresenceCour(Presence $presenceCour): self
    {
        if (!$this->presence_cours->contains($presenceCour)) {
            $this->presence_cours->add($presenceCour);
            $presenceCour->setPresenceCours($this);
        }

        return $this;
    }

    public function removePresenceCour(Presence $presenceCour): self
    {
        if ($this->presence_cours->removeElement($presenceCour)) {
            // set the owning side to null (unless already changed)
            if ($presenceCour->getPresenceCours() === $this) {
                $presenceCour->setPresenceCours(null);
            }
        }

        return $this;
    }
}
