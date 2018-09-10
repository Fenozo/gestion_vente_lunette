<?php

namespace AppBundle\Entity;
use AppBundle\Entity\UserInfos;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @UniqueEntity(
 * fields={"email"},
 * message="L'email que vous avez indiqué est déjà utilisé ! "
 * )
 * 
 */
class User implements UserInterface ,\Serializable
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
     * @ORM\Column(name="email", type="string", length=255)
     * 
     */
    private $email;

    /**
     * @var string
     * 
     * @ORM\Column(name="username", type="string", length=25,nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="text", length=255)
     * @Assert\Length(min=6, minMessage="Votre mot de passe doit faire minimum 6 caractères! ")
     * @Assert\NotBlank(payload={"severity"="error"}, message="Le champ Mot de passe  ne doit pas être vide ! ")
     */
    private $password;

    /**
     * 
     * @Assert\EqualTo(propertyPath="password", message="Vous n'avez pas tapez le même mot de passe !")
     * @Assert\NotBlank(payload={"severity"="error"}, message="Le champ Confirme mot de passe  ne doit pas être vide ! ")
     */
    private $confirm_password;

    /**
     *  @ORM\OneToOne(targetEntity="UserInfos", cascade={"persist","remove","refresh","merge","detach"})
     *  @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $userinfos;

    /**
     *  @ORM\OneToMany(targetEntity="AppBundle\Entity\Facture",mappedBy="user", cascade={"persist","refresh"})
     *  
     */
    private $factures;
    

    /**
     * @ORM\Column(type="text",nullable=true)
     * 
     */
    private $roles;
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
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
     * Set email
     *
     * @param string $email
     *
     * @return User
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username = null)
    {
        if($username == null) {
            $prename = $this->getPrename();
            $username = str_replace(arra(' ','.',','), "", $prename);
        }
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function setConfirmPassword($confirm_password) {
        $this->confirm_password = $confirm_password;
        return $this;
    }
    public function getConfirmPassword () {
        return $this->confirm_password;
    }

    public function setRoles($roles = null)
    {
        if($roles == null) {
            $roles = ['ROLE_ADMIN'];
        }
        $this->roles = json_encode($roles);

        return $this;
    }
    public function getRoles(): array
    {
        //return array_unique(array_merge(['ROLE_USER'], $this->roles));
        $tmpRoles = [];
        
        if(!is_array($this->roles)) {
            if(is_array(json_decode($this->roles))) {
                $tmpRoles = json_decode($this->roles);
            } 
        }
        
        if(in_array('ROLE_USER', $tmpRoles ) == false) {
            //var_dump(json_decode($this->roles));
            //$tmpRoles[] = 'ROLE_USER';
        }
        return $tmpRoles;
    }

    
    
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }


    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized, array('allowed_classes' => false));
    }

 
    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }



    /**
     * Set userinfos
     *
     * @param \AppBundle\Entity\UserInfos $userinfos
     *
     * @return User
     */
    public function setUserinfos(\AppBundle\Entity\UserInfos $userinfos = null)
    {
        $this->userinfos = $userinfos;

        return $this;
    }

    /**
     * Get userinfos
     *
     * @return \AppBundle\Entity\UserInfos
     */
    public function getUserinfos()
    {
        return $this->userinfos;
    }

    /**
     * Add facture
     *
     * @param \AppBundle\Entity\Facture $facture
     *
     * @return User
     */
    public function addFacture(\AppBundle\Entity\Facture $facture)
    {
        $this->factures[] = $facture;

        return $this;
    }

    /**
     * Remove facture
     *
     * @param \AppBundle\Entity\Facture $facture
     */
    public function removeFacture(\AppBundle\Entity\Facture $facture)
    {
        $this->factures->removeElement($facture);
    }

    /**
     * Get factures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFactures()
    {
        return $this->factures;
    }
}
