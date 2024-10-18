<?php

namespace App\Entity;

use App\Repository\DistanceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DistanceRepository::class)]
class Distance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $kilometres = null;

    #[ORM\ManyToOne(inversedBy: 'lesDistances')]
    private ?Entrepot $lEntrepot = null;

    #[ORM\ManyToOne(inversedBy: 'lesDistances')]
    private ?Ville $laVille = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getKilometres(): ?int
    {
        return $this->kilometres;
    }

    public function setKilometres(int $kilometres): static
    {
        $this->kilometres = $kilometres;

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

    public function getLaVille(): ?Ville
    {
        return $this->laVille;
    }

    public function setLaVille(?Ville $laVille): static
    {
        $this->laVille = $laVille;

        return $this;
    }

    
}
