<?php
namespace AppBundle\Helper\Security;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use AppBundle\Entity\User;

class Voter {

    private $user;

    public function __construct(?Container $container = null) {
        $this->container = $container;
    }
    public function getUser() {
         
        return $this->user;
    }
    
    public function isConnected() {
        $this->user = $this->get('security.token_storage')->getToken()->getUser();
        
        if  ( $this->user == "anon." || $this->user == "")  {
            $this->user = new User();
            return false;
        }   else    {
            return true;
        }
    }

    public function isAdmin() {
    	return $this->hasAccess('ROLE_ADMIN');
    }

    public function isClient() {
        return $this->hasAccess('ROLE_CLIENT');
    }
 
    public function hasAccess($role) {

        if (true === 
            $this->get('security.authorization_checker')->isGranted($role)) {
           	return 3;
        } else {
         	return 1;
        }
          
    }

    public function get($service){
        return $this->container->get($service);
    }


}