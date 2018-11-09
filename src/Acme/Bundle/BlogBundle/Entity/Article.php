<?php

namespace Acme\Bundle\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 *
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="Acme\Bundle\BlogBundle\Repository\ArticleRepository")
 */
class Article
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\Column(name="titre", type="integer")
     * 
     */
    private $titre;

    /**
     * @ORM\Column(name="description", type="integer")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Acme\Bundle\BlogBundle\Entity\Category", inversedBy="articles", cascade={"persist","remove"})
     */
    private $category;


    /**
     * Set titre
     *
     * @param integer $titre
     *
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return integer
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param integer $description
     *
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return integer
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set category
     *
     * @param \Acme\Bundle\BlogBundle\Entity\Category $category
     *
     * @return Article
     */
    public function setCategory(\Acme\Bundle\BlogBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Acme\Bundle\BlogBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }
}
