<?php

namespace App\Entity;

use App\Repository\EntrepotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepotRepository::class)]
class Entrepot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $entrepotNbCasier = 0;

    #[ORM\Column]
    private ?bool $status = false;

    /**
     * @var Collection<int, Casier>
     */
    #[ORM\OneToMany(targetEntity: Casier::class, mappedBy: 'lEntrepot')]
    private Collection $lesCasiers;

    /**
     * @var Collection<int, Distance>
     */
    #[ORM\OneToMany(targetEntity: Distance::class, mappedBy: 'lEntrepot')]
    private Collection $lesDistances;

    public function __construct()
    {
        $this->lesCasiers = new ArrayCollection();
        $this->lesDistances = new ArrayCollection();
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

    public function getEntrepotNbCasier(): ?int
    {
        return $this->entrepotNbCasier;
    }

    public function setEntrepotNbCasier(int $entrepotNbCasier): self
    {
        $this->entrepotNbCasier = $entrepotNbCasier;

        return $this;
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

    /**
     * @return Collection<int, Casier>
     */
    public function getLesCasiers(): Collection
    {
        return $this->lesCasiers;
    }

    public function addLesCasier(Casier $lesCasier): static
    {
        if (!$this->lesCasiers->contains($lesCasier)) {
            $this->lesCasiers->add($lesCasier);
            $lesCasier->setLEntrepot($this);
        }

        return $this;
    }

    public function removeLesCasier(Casier $lesCasier): static
    {
        if ($this->lesCasiers->removeElement($lesCasier)) {
            // set the owning side to null (unless already changed)
            if ($lesCasier->getLEntrepot() === $this) {
                $lesCasier->setLEntrepot(null);
            }
        }

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
            $lesDistance->setLEntrepot($this);
        }

        return $this;
    }

    public function removeLesDistance(Distance $lesDistance): static
    {
        if ($this->lesDistances->removeElement($lesDistance)) {
            // set the owning side to null (unless already changed)
            if ($lesDistance->getLEntrepot() === $this) {
                $lesDistance->setLEntrepot(null);
            }
        }

        return $this;
    }

    public function verifStatusEntrepot():bool
    {
        $nbCasierTrue = 0;
        foreach($this->lesCasiers as $casier){
            if ($casier === true)
            {
                $nbCasierTrue+=1;
            }
        }
        if($nbCasierTrue === $this->entrepotNbCasier){
                return true;
        }
        else{
            return false;
        }
    }

    public function modifierStatusEntrepot(): void
    {
        if($this->verifStatusEntrepot()===true)
        {
            $this->status=true;
        }
    }

    public function incrementNbCasiers(int $nbCasiers): self
    {
        $this->nbCasiers += $nbCasiers;
        return $this;
    }

    public function decrementNbCasiers(int $nbCasiers): self
    {
        $this->nbCasiers -= $nbCasiers;
        return $this;
    }
}
