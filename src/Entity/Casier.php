<?php

namespace App\Entity;

use App\Repository\CasierRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CasierRepository::class)]
class Casier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    


    #[ORM\Column]
    private ?bool $status = false;

    #[ORM\ManyToOne(targetEntity: Entrepot::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Entrepot $entrepot = null;

    #[ORM\Column]
    private ?int $nombreCasiers = 0;
    
    #[ORM\Column]
    private ?int $nombreCases = 9;

public function getNombreCasiers(): ?int
{
    return $this->nombreCasiers;
}

public function getNombreCases(): ?int
{
    return $this->nombreCases;
}

public function setNombreCasiers(int $nombreCasiers): static
{
    $this->nombreCasiers = $nombreCasiers;

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

