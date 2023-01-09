<?php

namespace App\Entity;

use App\Repository\ReferenceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReferenceRepository::class)
 */
class Reference
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
    private $nomRefernce;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $prenomRefernce;

    /**
     * @ORM\OneToMany(targetEntity=Session::class, mappedBy="reference", orphanRemoval=true)
     */
    private $sessions;

    public function __construct()
    {
        $this->sessions = new ArrayCollection();
    }

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomRefernce(): ?string
    {
        return $this->nomRefernce;
    }

    public function setNomRefernce(string $nomRefernce): self
    {
        $this->nomRefernce = $nomRefernce;

        return $this;
    }

    public function getPrenomRefernce(): ?string
    {
        return $this->prenomRefernce;
    }

    public function setPrenomRefernce(string $prenomRefernce): self
    {
        $this->prenomRefernce = $prenomRefernce;

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): self
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions[] = $session;
            $session->setReference($this);
        }

        return $this;
    }

    public function removeSession(Session $session): self
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getReference() === $this) {
                $session->setReference(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
       return $this->nomRefernce ." ".$this->prenomRefernce ;
    }

  
}
