<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommandesRepository")
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     * @var string
     *
     * @ORM\Column(name="prix_unitaire", type="decimal", precision=10, scale=0)
     */
    private $prixUnitaire;

    /**
     * @var string
     *
     * @ORM\Column(name="prix_unitaire_ttc", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $prixUnitaireTtc;

    /**
     * @var string
     *
     * @ORM\Column(name="quantite", type="decimal", precision=10, scale=0, nullable=true)
     */
    public $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="prixTotal", type="decimal", precision=10, scale=0)
     */
    private $prixTotal;

    /**
     * @var string
     *
     * @ORM\Column(name="taux_tva", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $tauxTva;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produit",  inversedBy="commandes",cascade={"persist"})
     *
     * @var [type]
     */
    private $produit;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Facture",  inversedBy="commandes",cascade={"persist"})
     *
     * @var [type]
     */
    private $facture;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set tauxTva
     *
     * @param string $tauxTva
     *
     * @return Prix
     */
    public function setTauxTva($tauxTva)
    {
        $this->tauxTva = $tauxTva;

        return $this;
    }

    /**
     * Get tauxTva
     *
     * @return string
     */
    public function getTauxTva()
    {
        return $this->tauxTva;
    }
    
    public function setQuantite($quantite) {
        $this->quantite = $quantite;
        return $this;
    }

    public function getQuantite() {
        return $this->quantite;
    }


    /**
     * Set prixTotal
     *
     * @param string $prixTotal
     *
     * @return Commandes
     */
    public function setprixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    /**
     * Get prixTotal
     *
     * @return string
     */
    public function getprixTotal()
    {
        return $this->prixTotal;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Commandes
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Commandes
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Commandes
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return int
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set produit
     *
     * @param \AppBundle\Entity\Produit $produit
     *
     * @return Commande
     */
    public function setProduit(\AppBundle\Entity\Produit $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \AppBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return Commande
     */
    public function setFacture(\AppBundle\Entity\Facture $facture = null)
    {
        $this->facture = $facture;

        return $this;
    }

    /**
     * Get facture
     *
     * @return \AppBundle\Entity\Facture
     */
    public function getFacture()
    {
        return $this->facture;
    }

    /**
     * Set prixUnitaire
     *
     * @param string $prixUnitaire
     *
     * @return Commande
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * Get prixUnitaire
     *
     * @return string
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * Set prixUnitaireTtc
     *
     * @param string $prixUnitaireTtc
     *
     * @return Commande
     */
    public function setPrixUnitaireTtc($prixUnitaireTtc)
    {
        $this->prixUnitaireTtc = $prixUnitaireTtc;

        return $this;
    }

    /**
     * Get prixUnitaireTtc
     *
     * @return string
     */
    public function getPrixUnitaireTtc()
    {
        return $this->prixUnitaireTtc;
    }
}
