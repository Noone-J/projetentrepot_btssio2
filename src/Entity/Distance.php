<?php

namespace App\Entity;

use App\Repository\DistanceRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Ville; // N'oublie pas d'importer l'entité Ville
use App\Entity\Entrepot; // N'oublie pas d'importer l'entité Entrepot

#[ORM\Entity(repositoryClass: DistanceRepository::class)]
class Distance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $kilometres = null;

    #[ORM\ManyToOne(targetEntity: Ville::class)]
    #[ORM\JoinColumn(nullable: false)] // La ville ne peut pas être nulle
    private ?Ville $ville = null; // Ajout de la relation avec Ville

    #[ORM\ManyToOne(targetEntity: Entrepot::class)]
    #[ORM\JoinColumn(nullable: false)] // L'entrepôt ne peut pas être nul
    private ?Entrepot $entrepot = null; // Ajout de la relation avec Entrepot

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

    public function getVille(): ?Ville // Méthode pour récupérer la ville
    {
        return $this->ville;
    }

    public function setVille(?Ville $ville): static // Méthode pour définir la ville
    {
        $this->ville = $ville;

        return $this;
    }

    public function getEntrepot(): ?Entrepot // Méthode pour récupérer l'entrepôt
    {
        return $this->entrepot;
    }

    public function setEntrepot(?Entrepot $entrepot): static // Méthode pour définir l'entrepôt
    {
        $this->entrepot = $entrepot;

        return $this;
    }
}
