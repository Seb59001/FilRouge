<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
class Eleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[ORM\Column(length: 255)]
    private ?string $sexe = null;

    #[ORM\Column(length: 255)]
    private ?string $niveau_etude = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'presence_eleve', targetEntity: Presence::class)]
    private Collection $presence_eleve;

    public function __construct()
    {
        $this->presence_eleve = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getNiveauEtude(): ?string
    {
        return $this->niveau_etude;
    }

    public function setNiveauEtude(string $niveau_etude): self
    {
        $this->niveau_etude = $niveau_etude;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Presence>
     */
    public function getPresenceEleve(): Collection
    {
        return $this->presence_eleve;
    }

    public function addPresenceEleve(Presence $presenceEleve): self
    {
        if (!$this->presence_eleve->contains($presenceEleve)) {
            $this->presence_eleve->add($presenceEleve);
            $presenceEleve->setPresenceEleve($this);
        }

        return $this;
    }

    public function removePresenceEleve(Presence $presenceEleve): self
    {
        if ($this->presence_eleve->removeElement($presenceEleve)) {
            // set the owning side to null (unless already changed)
            if ($presenceEleve->getPresenceEleve() === $this) {
                $presenceEleve->setPresenceEleve(null);
            }
        }

        return $this;
    }
}