<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Produit
 *
 * @ORM\Table(name="produit")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProduitRepository")
 * 
 * 
 */
class Produit
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
     * @Assert\NotBlank(payload={"severity"="error"}, message="Le produit doit avoir au moins un titre ! ")
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * 
     *  @ORM\Column(name="image", type="string", length=255,nullable=true)
     *  @Assert\File(mimeTypes={ "image/jpeg", "image/gif", "image/png","image/jpg" }, mimeTypesMessage = "Wrong file type (jpg,gif,png)")
     */
    private $image;
    
    /**
     * @var string
     * @Assert\Valid()
     * @Assert\NotBlank(payload={"severity"="error"}, message="Le produit doit avoir au moins une petite déscription ! ")
     * @ORM\Column(name="description", type="text")
     */
    private $description;
    /**
     * @var string
     *
     * @ORM\Column(name="quantite", type="decimal", precision=10, scale=0, nullable=true)
     */
    public $quantite;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="genre", type="integer")
     */
    private $genre;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Mouvement",  mappedBy="produit", orphanRemoval=true,cascade={"remove", "persist"})
     *
     */
    private $mouvements;


    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Fournisseur",  inversedBy="produits",cascade={"persist"})
     *
     * @var [type]
     */
    private $fournisseur;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Commande", mappedBy="produit" );
     */
    private $commandes;

    /**
     *
     * @var \Datetime
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;


  


    public function setId($id) {
        $this->id = $id;
        return $this;
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
     * Set titre
     *
     * @param string $titre
     *
     * @return Produit
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set image
     *
     * @param string $image
     * 
     * @return Produit
     */
    public function setImage($image) {
        $this->image = $image;
        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Produit
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

 

    /**
     * Set genre
     *
     * @param integer $genre
     *
     * @return Produit
     */
    public function setGenre($genre)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return int
     */
    public function getGenre()
    {
        return $this->genre;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Produit
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public function setQuantite($quantite) {
        $this->quantite = $quantite;
        return $this;
    }

    public function getQuantite() {
        return $this->quantite;
    }
    
    /**
     * Set \Datetime
     *
     * @param [type] $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get Datetime
     *
     * @return void
     */
    public function getCreatedAt() {
        return $this->createdAt;
    }
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->mouvements = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add mouvement
     *
     * @param \AppBundle\Entity\Mouvement $mouvement
     *
     * @return Produit
     */
    public function addMouvement(\AppBundle\Entity\Mouvement $mouvement)
    {
        $this->mouvements[] = $mouvement;

        return $this;
    }

    /**
     * Remove mouvement
     *
     * @param \AppBundle\Entity\Mouvement $mouvement
     */
    public function removeMouvement(\AppBundle\Entity\Mouvement $mouvement)
    {
        $this->mouvements->removeElement($mouvement);
    }

    /**
     * Get mouvements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMouvements()
    {
        return $this->mouvements;
    }

    /**
     * Set fournisseur
     *
     * @param \AppBundle\Entity\Fournisseur $fournisseur
     *
     * @return Produit
     */
    public function setFournisseur(\AppBundle\Entity\Fournisseur $fournisseur = null)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \AppBundle\Entity\Fournisseur
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }

    /**
     * Add commande
     *
     * @param \AppBundle\Entity\Commande $commande
     *
     * @return Produit
     */
    public function addCommande(\AppBundle\Entity\Commande $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \AppBundle\Entity\Commande $commande
     */
    public function removeCommande(\AppBundle\Entity\Commande $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

}
