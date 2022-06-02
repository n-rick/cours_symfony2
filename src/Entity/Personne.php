<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonneRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[UniqueEntity(fields: ["nom", "prenom"], message: "Les nom et prénom existent déjà")]
class Personne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    #[Assert\Length(
        min: 2,
        max: 20,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères",
        maxMessage: "Le nom doit contenir au plus {{ limit }} caractères",
    )]
    private $nom;

    #[Assert\Regex('/^[A-Z]{1}[a-z ]{2,29}$/')]
    #[ORM\Column(type: 'string', length: 30, nullable: true)]
    private $prenom;

    #[ORM\OneToOne(targetEntity: Adresse::class, cascade: ['persist', 'remove'])]
    private $adresse;

    #[ORM\ManyToMany(targetEntity: Sport::class, cascade: ['persist', 'remove'])]
    private $sports;

    public function __construct()
    {
        $this->sports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Sport>
     */
    public function getSports(): Collection
    {
        return $this->sports;
    }

    public function addSport(Sport $sport): self
    {
        if (!$this->sports->contains($sport)) {
            $this->sports[] = $sport;
        }

        return $this;
    }

    public function removeSport(Sport $sport): self
    {
        $this->sports->removeElement($sport);

        return $this;
    }
}
