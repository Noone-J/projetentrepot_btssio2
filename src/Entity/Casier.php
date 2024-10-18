<?php

namespace App\Entity;

use App\Repository\CasierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Entrepot;
#[ORM\Entity(repositoryClass: CasierRepository::class)]
class Casier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    private $compartiments;
    private $colis;
    #[ORM\Column]
    private ?bool $status = false;

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
        $this->compartiments = range(0, 8);
        $this->colis = [];

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

 
    public function addLesCompartiment(Compartiment $compartiment): self
    {
        $this->lesCompartiments[] = $compartiment;
        $compartiment->setLeCasier($this); // Associer le compartiment au casier
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

    public function verifStatusCasier():bool
    {
        $nbCompartimentTrue = 0;
        foreach($this->lesCompartiments as $compartiment){
            if ($compartiment === true)
            {
                $nbCompartimentTrue+=1;
            }
        }
        if($nbCompartimentTrue === 9){
                return true;
        }
        else{
            return false;
        }
    }

    public function modifierStatusCasier(): void
    {
        if($this->verifStatusCasier()===true)
        {
            $this->status=true;
        }
    }


    public function ajouterColis($taille) {
        $compteur = 0;
        foreach ($this->compartiments as $i => $compartiment) {
            if ($compteur < count($this->colis)) {
                continue;
            }
            
            if ($taille == 1 && !in_array($compartiment, $this->colis)) {
                $this->colis[] = $compartiment;
                $compteur++;
            } elseif ($taille == 2 && $compteur < count($this->colis) + 1 && !in_array($compartiment, $this->colis)) {
                $this->colis[] = $compartiment;
                $compteur++;
            } elseif ($taille == 3 && $compteur < count($this->colis) + 2 && !in_array($compartiment, $this->colis)) {
                $this->colis[] = $compartiment;
                $compteur++;
            }
        }
    }

    public function afficherCasier() {
        $affichage = '';
        foreach ($this->compartiments as $i => $compartiment) {
            if (!in_array($compartiment, $this->colis)) {
                $affichage .= '- ';
            } else {
                $affichage .= $compartiment . ' ';
            }
            
            if (($i + 1) % 3 === 0) {
                $affichage .= "\n";
            }
        }
        return $affichage;
    }

    public function getnbCasiers(): ?int
    {
        // Vérification que l'entrepôt est bien défini
        if ($this->lEntrepot === null) {
            return 0;
        }
        
        // Récupération du nombre de casiers dans l'entrepôt
        return $this->lEntrepot->getLesCasiers()->count();
    }

    public function setnbLEntrepot(?Entrepot $lEntrepot): self
    {
        // Si l'entrepôt est changé, décrémenter le nombre de casiers de l'ancien entrepôt
        if ($this->lEntrepot !== null) {
            $this->lEntrepot->decrementNbCasiers(1);
        }

        $this->lEntrepot = $lEntrepot;

        // Incrémenter le nombre de casiers de l'entrepôt associé
        if ($lEntrepot !== null) {
            $lEntrepot->incrementNbCasiers(1);
        }

        return $this;
    }
}
