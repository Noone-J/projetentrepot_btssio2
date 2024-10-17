<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Casier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = false;

    #[ORM\Column]
    private ?int $nombreCasiers = 0;


    #[ORM\ManyToOne(targetEntity: Entrepot::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entrepot $entrepot = null;

    #[ORM\OneToMany(mappedBy: 'leCasier', targetEntity: Compartiment::class, cascade: ['persist', 'remove'])]
    private Collection $lesCompartiments;

    public function __construct()
    {
        $this->lesCompartiments = new ArrayCollection();
    }

    public function getNombreCasiers(): ?int
{
    return $this->nombreCasiers;
}

public function setNombreCasiers(int $nombreCasiers): static
{
    $this->nombreCasiers = $nombreCasiers;

    return $this;
}


    /**
     * @return Collection<int, Compartiment>
     */
    public function getLesCompartiments(): Collection
    {
        return $this->lesCompartiments;
    }

    public function addCompartiment(Compartiment $compartiment): static
    {
        if (!$this->lesCompartiments->contains($compartiment)) {
            $this->lesCompartiments[] = $compartiment;
            $compartiment->setLeCasier($this);
        }

        return $this;
    }

    public function removeCompartiment(Compartiment $compartiment): static
    {
        if ($this->lesCompartiments->removeElement($compartiment)) {
            // Si le compartiment était associé à ce casier, on retire l'association
            if ($compartiment->getLeCasier() === $this) {
                $compartiment->setLeCasier(null);
            }
        }

        return $this;
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

    public function getEntrepot(): ?Entrepot
    {
        return $this->entrepot;
    }

    public function setEntrepot(?Entrepot $entrepot): static
    {
        $this->entrepot = $entrepot;

        return $this;
    }
}
