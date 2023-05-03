<?php

namespace App\Entity;

use App\Repository\EleveRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EleveRepository::class)]
#[UniqueEntity('email')]
class Eleve
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    #[Assert\Choice(['Masculin', 'Féminin'])]
    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $sexe = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $niveau_etude = null;

    #[Assert\NotBlank]
    #[Assert\Email()]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'presence_eleve', targetEntity: Presence::class)]
    private Collection $presence_eleve;

    #[ORM\ManyToMany(targetEntity: Cours::class, mappedBy: 'eleve_inscrit')]
    private Collection $cours;

    public function __construct()
    {
        $this->presence_eleve = new ArrayCollection();
        $this->cours = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nom;
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

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours->add($cour);
            $cour->addEleveInscrit($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            $cour->removeEleveInscrit($this);
        }

        return $this;
    }
}