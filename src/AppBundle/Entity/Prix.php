<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prix
 *
 * @ORM\Table(name="prix")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PrixRepository")
 */
class Prix
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
     * @ORM\Column(name="taux_tva", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $tauxTva;


    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer", nullable=true)
     */
    private $etat;

    /**
     * @var int
     *
     * @ORM\Column(name="produit_id", type="integer", nullable=true)
     */
    private $produit_id;

    public function setId($id) {
        $this->id = $id;
    }
    
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
     * Set prixUnitaire
     *
     * @param string $prixUnitaire
     *
     * @return Prix
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
     * @return Prix
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

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Prix
     */
    public function setEtat($etat = null)
    {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Get etat
     *
     * @return integer
     */
    public function getEtat()
    {
        return $this->etat;
    }

 

    /**
     * Set produitId
     *
     * @param integer $produitId
     *
     * @return Prix
     */
    public function setProduitId($produitId)
    {
        $this->produit_id = $produitId;

        return $this;
    }

    /**
     * Get produitId
     *
     * @return integer
     */
    public function getProduitId()
    {
        return $this->produit_id;
    }
}
