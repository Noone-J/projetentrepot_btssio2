<?php

namespace App\Entity;

use App\Repository\ColisRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ColisRepository::class)]
class Colis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $taille = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\ManyToOne(inversedBy: 'lesColis')]
    private ?Ville $laVille = null;

    /**
     * @var Collection<int, Compartiment>
     */
    #[ORM\OneToMany(targetEntity: Compartiment::class, mappedBy: 'leColis')]
    private Collection $lesCompartiments;

    public function __construct()
    {
        $this->lesCompartiments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTaille(): ?int
    {
        return $this->taille;
    }

    public function setTaille(int $taille): static
    {
        $this->taille = $taille;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    public function getLaVille(): ?Ville
    {
        return $this->laVille;
    }

    public function setLaVille(?Ville $laVille): static
    {
        $this->laVille = $laVille;

        return $this;
    }

    /**
     * @return Collection<int, Compartiment>
     */
    public function getLesCompartiments(): Collection
    {
        return $this->lesCompartiments;
    }

    public function addLesCompartiment(Compartiment $lesCompartiment): static
    {
        if (!$this->lesCompartiments->contains($lesCompartiment)) {
            $this->lesCompartiments->add($lesCompartiment);
            $lesCompartiment->setLeColis($this);
        }

        return $this;
    }

    public function removeLesCompartiment(Compartiment $lesCompartiment): static
    {
        if ($this->lesCompartiments->removeElement($lesCompartiment)) {
            // set the owning side to null (unless already changed)
            if ($lesCompartiment->getLeColis() === $this) {
                $lesCompartiment->setLeColis(null);
            }
        }

        return $this;
    }
}
