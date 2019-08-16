<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompteRepository")
 */
class Compte
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $montant;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numcompte;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Prestataire")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idprestataire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getNumcompte(): ?string
    {
        return $this->numcompte;
    }

    public function setNumcompte(string $numcompte): self
    {
        $this->numcompte = $numcompte;

        return $this;
    }

    public function getIdprestataire(): ?Prestataire
    {
        return $this->idprestataire;
    }

    public function setIdprestataire(?Prestataire $idprestataire): self
    {
        $this->idprestataire = $idprestataire;

        return $this;
    }
}
