<?php

namespace App\Entity;

use App\Repository\CompartimentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompartimentRepository::class)]
class Compartiment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(nullable: true)]
    private ?int $contenu = null;

    #[ORM\ManyToOne(inversedBy: 'lesCompartiments')]
    private ?Casier $leCasier = null;

    #[ORM\ManyToOne(inversedBy: 'lesCompartiments')]
    private ?Colis $leColis = null;

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

    public function getContenu(): ?int
    {
        return $this->contenu;
    }

    public function setContenu(?int $contenu): static
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getLeCasier(): ?Casier
    {
        return $this->leCasier;
    }

    public function setLeCasier(?Casier $leCasier): static
    {
        $this->leCasier = $leCasier;

        return $this;
    }

    public function getLeColis(): ?Colis
    {
        return $this->leColis;
    }

    public function setLeColis(?Colis $leColis): static
    {
        $this->leColis = $leColis;

        return $this;
    }
}
