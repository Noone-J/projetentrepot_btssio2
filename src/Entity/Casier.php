<?php

namespace App\Entity;

use App\Repository\CasierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CasierRepository::class)]
class Casier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column]
    private ?int $taille = null;

    #[ORM\ManyToOne(inversedBy: 'lesCasiers')]
    private ?Entrepot $lEntrepot = null;

    /**
     * @var Collection<int, Compartiment>
     */
    #[ORM\OneToMany(targetEntity: Compartiment::class, mappedBy: 'leCasier')]
    private Collection $lesCompartiments;

    public function __construct()
    {
        $this->lesCompartiments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
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

    public function getLEntrepot(): ?Entrepot
    {
        return $this->lEntrepot;
    }

    public function setLEntrepot(?Entrepot $lEntrepot): static
    {
        $this->lEntrepot = $lEntrepot;

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
            $lesCompartiment->setLeCasier($this);
        }

        return $this;
    }

    public function removeLesCompartiment(Compartiment $lesCompartiment): static
    {
        if ($this->lesCompartiments->removeElement($lesCompartiment)) {
            // set the owning side to null (unless already changed)
            if ($lesCompartiment->getLeCasier() === $this) {
                $lesCompartiment->setLeCasier(null);
            }
        }

        return $this;
    }
}
