<?php

namespace AppBundle\Entity;
use AppBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * UserInfos
 *
 * @ORM\Table(name="user_infos")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserInfosRepository")
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email que vous avez indiqué est déjà utilisé ! "
 * )
 */
class UserInfos
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
     *
     * @ORM\OneToOne(targetEntity="User", mappedBy = "userinfos")
     */
    private $currentUser;

    /**
     * @var string
     * 
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\Length(min=4, minMessage="Votre nom  doit faire minimum 4 caractères ! ")
     * @Assert\NotBlank(payload={"severity"="error"}, message="Le champ Nom ne doit pas être vide ! ")
     */
    private $name;

    /**
     * @var string
     * 
     * @ORM\Column(name="prename", type="string", length=255)
     * @Assert\Length(min=2, minMessage="Votre nom  doit faire minimum 2 caractères ! ")
     * @Assert\NotBlank(payload={"severity"="error"}, message="Le champ Prénom ne doit pas être vide ! ")
     */
    private $prename;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank(payload={"severity"="error"}, message="Le champ email  ne doit pas être vide ! ")
     */
    private $email;

    /**
     * @var string
     * 
     * @ORM\Column(name="adress", type="string", length=255)
     * @Assert\Length(min=3, minMessage="Votre adresse doit faire minimum 3 caractères ! ")
     * @Assert\NotBlank(payload={"severity"="error"}, message="Le champ adresse  ne doit pas être vide ! ")
     */
    private $adress;

    /**
     * @var string
     * 
     * @ORM\Column(name="phone", type="string", length=22)
     * @Assert\Length(min=10, minMessage="Votre numéro de téléphone doit faire minimum 10 caractères ! ")
     * @Assert\NotBlank(payload={"severity"="error"}, message="Le champ numéro de téléphone  ne doit pas être vide ! ")
     */
    private $phone;


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
     * Set name
     *
     * @param string $name
     *
     * @return UserInfos
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set prename
     *
     * @param string $prename
     *
     * @return UserInfos
     */
    public function setPrename($prename)
    {
        $this->prename = $prename;

        return $this;
    }

    /**
     * Get prename
     *
     * @return string
     */
    public function getPrename()
    {
        return $this->prename;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return UserInfos
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return UserInfos
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return UserInfos
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set currentUser
     *
     * @param \AppBundle\Entity\User $currentUser
     *
     * @return UserInfos
     */
    public function setCurrentUser(\AppBundle\Entity\User $currentUser = null)
    {
        $this->currentUser = $currentUser;

        return $this;
    }

    /**
     * Get currentUser
     *
     * @return \AppBundle\Entity\User
     */
    public function getCurrentUser()
    {
        return $this->currentUser;
    }
}
