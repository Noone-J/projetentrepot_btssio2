<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Distance>
     */
    #[ORM\OneToMany(targetEntity: Distance::class, mappedBy: 'laVille')]
    private Collection $lesDistances;

    /**
     * @var Collection<int, Colis>
     */
    #[ORM\OneToMany(targetEntity: Colis::class, mappedBy: 'laVille')]
    private Collection $lesColis;

    public function __construct()
    {
        $this->lesDistances = new ArrayCollection();
        $this->lesColis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Distance>
     */
    public function getLesDistances(): Collection
    {
        return $this->lesDistances;
    }

    public function addLesDistance(Distance $lesDistance): static
    {
        if (!$this->lesDistances->contains($lesDistance)) {
            $this->lesDistances->add($lesDistance);
            $lesDistance->setLaVille($this);
        }

        return $this;
    }

    public function removeLesDistance(Distance $lesDistance): static
    {
        if ($this->lesDistances->removeElement($lesDistance)) {
            // set the owning side to null (unless already changed)
            if ($lesDistance->getLaVille() === $this) {
                $lesDistance->setLaVille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Colis>
     */
    public function getLesColis(): Collection
    {
        return $this->lesColis;
    }

    public function addLesColi(Colis $lesColi): static
    {
        if (!$this->lesColis->contains($lesColi)) {
            $this->lesColis->add($lesColi);
            $lesColi->setLaVille($this);
        }

        return $this;
    }

    public function removeLesColi(Colis $lesColi): static
    {
        if ($this->lesColis->removeElement($lesColi)) {
            // set the owning side to null (unless already changed)
            if ($lesColi->getLaVille() === $this) {
                $lesColi->setLaVille(null);
            }
        }

        return $this;
    }

    public function getMinDistanceEntrepot(Ville $ville): ?Entrepot
    {
        
        if ($ville === $this->getLaVille()) {
            return null;
        }

        $minDistance = null;
        $entrepotMin = null;

        foreach ($this->lesDistances as $distance) {
            // Vérifiez si la distance est associée à la ville spécifiée
            if ($distance->getLaVille() === $ville) {
                $kilometres = $distance->getKilometres();

                // Vérifier si la distance actuelle est la plus petite
                if ($minDistance === null || $kilometres < $minDistance) {
                    $minDistance = $kilometres;
                    $entrepotMin = $distance->getLEntrepot(); // Obtenez l'entrepôt associé à cette distance
                }
            }
        }

        return $entrepotMin; // Retournez l'entrepôt avec la distance minimale
    }
}
