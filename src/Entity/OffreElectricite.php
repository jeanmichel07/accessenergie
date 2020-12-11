<?php

namespace App\Entity;

use App\Repository\OffreElectriciteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreElectriciteRepository::class)
 */
class OffreElectricite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fournisseur;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $segmentation;

    /**
     * @ORM\OneToMany(targetEntity=DetailOffreElec::class, mappedBy="offre")
     */
    private $detailOffreElecs;

    public function __construct()
    {
        $this->detailOffreElecs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?string $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getSegmentation(): ?string
    {
        return $this->segmentation;
    }

    public function setSegmentation(?string $segmentation): self
    {
        $this->segmentation = $segmentation;

        return $this;
    }

    /**
     * @return Collection|DetailOffreElec[]
     */
    public function getDetailOffreElecs(): Collection
    {
        return $this->detailOffreElecs;
    }

    public function addDetailOffreElec(DetailOffreElec $detailOffreElec): self
    {
        if (!$this->detailOffreElecs->contains($detailOffreElec)) {
            $this->detailOffreElecs[] = $detailOffreElec;
            $detailOffreElec->setOffre($this);
        }

        return $this;
    }

    public function removeDetailOffreElec(DetailOffreElec $detailOffreElec): self
    {
        if ($this->detailOffreElecs->removeElement($detailOffreElec)) {
            // set the owning side to null (unless already changed)
            if ($detailOffreElec->getOffre() === $this) {
                $detailOffreElec->setOffre(null);
            }
        }

        return $this;
    }
}
