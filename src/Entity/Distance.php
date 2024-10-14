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
}
