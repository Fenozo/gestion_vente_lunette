<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Mouvements
 *
 * @ORM\Table(name="mouvements")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MouvementRepository")
 */
class Mouvement
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
     * @ORM\Column(name="quantite", type="decimal", precision=10, scale=0)
     */
    private $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="prixUnitaire", type="decimal", precision=10, scale=0)
     */
    private $prixUnitaire;

    /**
     * @var string
     *
     * @ORM\Column(name="tva", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $tva;

    /**
     * @var string
     *
     * @ORM\Column(name="prixTtc", type="decimal", precision=10, scale=0, nullable=true)
     */
    private $prixTtc;

    /**
     * @var string
     *
     * @ORM\Column(name="prixTotal", type="decimal", precision=10, scale=0)
     */
    private $prixTotal;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer")
     */
    private $etat;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Stock",  inversedBy="mouvements",cascade={"remove", "persist"})
     *
     * @var [type]
     */
    private $stock;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Produit",  inversedBy="mouvements",cascade={"remove", "persist"})
     *
     * @var [type]
     */
    private $produit;


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
     * Set quantite
     *
     * @param string $quantite
     *
     * @return Mouvements
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return string
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prixUnitaire
     *
     * @param string $prixUnitaire
     *
     * @return Mouvements
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
     * Set tva
     *
     * @param string $tva
     *
     * @return Mouvements
     */
    public function setTva($tva)
    {
        $this->tva = $tva;

        return $this;
    }

    /**
     * Get tva
     *
     * @return string
     */
    public function getTva()
    {
        return $this->tva;
    }

    /**
     * Set prixTtc
     *
     * @param string $prixTtc
     *
     * @return Mouvements
     */
    public function setPrixTtc($prixTtc)
    {
        $this->prixTtc = $prixTtc;

        return $this;
    }

    /**
     * Get prixTtc
     *
     * @return string
     */
    public function getPrixTtc()
    {
        return $this->prixTtc;
    }

    /**
     * Set prixTotal
     *
     * @param string $prixTotal
     *
     * @return Mouvements
     */
    public function setPrixTotal($prixTotal)
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    /**
     * Get prixTotal
     *
     * @return string
     */
    public function getPrixTotal()
    {
        return $this->prixTotal;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Mouvements
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set etat
     *
     * @param integer $etat
     *
     * @return Mouvements
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
     * @return Mouvement
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
     * Set stock
     *
     * @param \AppBundle\Entity\Stock $stock
     *
     * @return Mouvement
     */
    public function setStock(\AppBundle\Entity\Stock $stock = null)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return \AppBundle\Entity\Stock
     */
    public function getStock()
    {
        return $this->stock;
    }
}
