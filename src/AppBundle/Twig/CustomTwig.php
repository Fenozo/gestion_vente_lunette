<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Produit;
use AppBundle\Entity\Prix;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use \Twig_Filter_Method;
use \Twig_Filter_Function;
use AppBundle\Engine\Panier;
class CustomTwig extends \Twig_Extension
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    public function getFilters()
    {
        return array(
            new TwigFilter('price', array($this, 'priceFilter')),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('show_prix', [$this,'showPrix'],['is_safe' => array('html')]),
            new \Twig_SimpleFunction('show_produit', [$this,'showProduit'],['is_safe' => array('html')]),
            new \Twig_SimpleFunction('is_connected', [$this,'isConnected'],['is_safe' => array('html')]),
            new \Twig_SimpleFunction('is_client', [$this,'isClient'],['is_safe' => array('html')]),
            new \Twig_SimpleFunction('is_admin', [$this,'isAdmin'],['is_safe' => array('html')]),
            new \Twig_SimpleFunction('panier_count', [$this,'panierCount'],['is_safe' => array('html')]),
            
            new \Twig_SimpleFunction(
                'panier_total',
                [$this, 'panierTotal'],
                array('is_safe' =>  array('html'))

            ),new \Twig_SimpleFunction('activeClass', [$this,'activeClass'], 
                [
                    'needs_context' => true
                ]),
            new \Twig_SimpleFunction('type_lunette',[$this,'typeLunette'],
                ['is_safe'  => array('html')])
        );
    }

    public function showPrix($id) {
        $doctrine   =   $this->container->get('doctrine');
        $repo_prod  =   $doctrine->getRepository(Prix::class);
        $prix       =   $repo_prod->findOneBy([ 'produit_id'=> $id ,'etat'  => 1]);
        if( $prix == null || $prix == "" ) {
            $prix = new Prix();
        } 
        return $prix;
    }
    public function showProduit($key = null,$value = null,$field = null) {
        
        if (!is_null($key) && !is_null($value) && !is_null($field)) {
            $doctrine   =   $this->container->get('doctrine');
            $repo_prod  =   $doctrine->getRepository(Produit::class);
            $prod       =   $repo_prod->findOneBy([ $key=> $value]);
            $field      =   'get'.ucfirst($field);
            return $prod->$field();
        } else {
            return '';
        }
    }

    public function isConnected() {
        $voter = $this->container->get("app.voteur");
        
        return $voter->isConnected();
    }
    public function isClient() {
        $voter = $this->container->get("app.voteur");
        return $voter->isClient();
    }
    public function isAdmin() {
        $voter = $this->container->get("app.voteur");
        return $voter->isAdmin();
    }
    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$'.$price;

        return $price;
    }
    public function activeClass($context, $page) {
        if (isset($context['current_page']) && $context['current_page'] === $page){
            return ' active ';
        }
    }
    
    public function panierTotal($htt = null)
    {   
        $total = 0;
        $em         = $this->container->get('doctrine.orm.entity_manager');
        $panier     = new Panier($em);
        
        $total      = $panier->total();
        if ($htt == null ) {
            $total      = $panier->getTotalTtc();
        }
        
        return '<em>'.number_format($total,0,'.',',').'</em>';
    }

    public function panierCount() {
        $panier = new Panier();
        return '<span>'.$panier->count().'</span>';
    }


    public function substrTwig($text)
    {
        return mb_substr($text, 0, 150, 'UTF-8').'...';
    }

    public function typeLunette($key){
        $type = [
            1 => 'Soleil',
            2 => 'Vue',
            3 => 'Sport'
        ];
        if($key){
            return $type[$key];
        } else {
            return '';
        }
        
    }



    public function getName()
    {
        return 'collectify_twig_extension';
    } 
}
