<?php

namespace App\Entity;

use App\Entity\Programe;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CoursRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=CoursRepository::class)
 */
class Cours
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nomCours;

    /**
     * @ORM\OneToMany(targetEntity=Programe::class, mappedBy="cours", orphanRemoval=true)
     */
    private $programes;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="cours")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    public function __construct()
    {
        $this->programes = new ArrayCollection();
    }

   


   

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCours(): ?string
    {
        return $this->nomCours;
    }

    public function setNomCours(string $nomCours): self
    {
        $this->nomCours = $nomCours;

        return $this;
    }

    /**
     * @return Collection<int, Programe>
     */
    public function getProgrames(): Collection
    {
        return $this->programes;
    }

    public function addPrograme(Programe $programe): self
    {
        if (!$this->programes->contains($programe)) {
            $this->programes[] = $programe;
            $programe->setCours($this);
        }

        return $this;
    }

    public function removePrograme(Programe $programe): self
    {
        if ($this->programes->removeElement($programe)) {
            // set the owning side to null (unless already changed)
            if ($programe->getCours() === $this) {
                $programe->setCours(null);
            }
        }

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }


    public function __toString()
    {
       return $this->nomCours ." ".$this->categorie ;
    }


    

 






}
