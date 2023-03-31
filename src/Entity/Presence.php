<?php

namespace App\Entity;

use App\Repository\PresenceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenceRepository::class)]
class Presence
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'presence_eleve')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Eleve $presence_eleve = null;

    #[ORM\ManyToOne(inversedBy: 'presence_cours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cours $presence_cours = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_presence = null;

    #[ORM\Column]
    private ?bool $present = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPresenceEleve(): ?Eleve
    {
        return $this->presence_eleve;
    }

    public function setPresenceEleve(?Eleve $presence_eleve): self
    {
        $this->presence_eleve = $presence_eleve;

        return $this;
    }

    public function getPresenceCours(): ?Cours
    {
        return $this->presence_cours;
    }

    public function setPresenceCours(?Cours $presence_cours): self
    {
        $this->presence_cours = $presence_cours;

        return $this;
    }

    public function getDatePresence(): ?\DateTimeInterface
    {
        return $this->date_presence;
    }

    public function setDatePresence(\DateTimeInterface $date_presence): self
    {
        $this->date_presence = $date_presence;

        return $this;
    }

    public function isPresent(): ?bool
    {
        return $this->present;
    }

    public function setPresent(bool $present): self
    {
        $this->present = $present;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
