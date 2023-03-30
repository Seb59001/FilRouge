<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Type;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //Que ce soit une adresse mail, qu'elle soit unique dans la BDD
    #[ORM\Column(length: 180, unique: TRUE)]
    #[Assert\Email()]
    #[Assert\Length(min: 2 , max: 180)]
    private ?string $adress_mail = null;

// Ne peut pas être vide 
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    private ?string $password = null;


    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    private ?string $prenom = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Choice(['Femme', 'Homme', 'Non-binaire'])]
    private ?string $sexe = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]

    private ?string $telephone = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Choice(['Secretaire', 'Professeur', 'Autre'])]
    private ?string $emploi = null;


    // J'ai suivi le musclé mais il faudra peut être revoir 
    #[ORM\Column(length: 50)]
    #[Assert\NotNull()]
    private ?string $role = null ;

    #[ORM\OneToMany(mappedBy: 'user_cours', targetEntity: Cours::class)]
    private Collection $cours;

    public function __construct()
    {
        $this->cours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdressMail(): ?string
    {
        return $this->adress_mail;
    }

    public function setAdressMail(string $adress_mail): self
    {
        $this->adress_mail = $adress_mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
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

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

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

    public function getEmploi(): ?string
    {
        return $this->emploi;
    }

    public function setEmploi(string $emploi): self
    {
        $this->emploi = $emploi;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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
            $cour->setUserCours($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getUserCours() === $this) {
                $cour->setUserCours(null);
            }
        }

        return $this;
    }
}
