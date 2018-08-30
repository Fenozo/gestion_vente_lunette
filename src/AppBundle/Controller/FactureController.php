<?php

namespace AppBundle\Controller;
use AppBundle\Engine\Panier;
use AppBundle\Entity\Produit;
use AppBundle\Entity\User;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FactureController extends Controller{

    /**
     *
     * @Route("valider", name="valider_panier")   
     */
    public function valider_panier( ObjectManager $manager, Request $request ) {
        $total          = 0;
        $nobre_produit  = 0;

        $voter = $this->container->get("app.voteur");
        
        if  ($voter->isClient() != 3 && $voter->isConnected()) {
            dump($request->request);
            return $this->redirectToRoute('commande_detail',['id'=>$commnade->getId()]);
            // (new Panier())->removeAll();
        }
        $user = new User();
        if ($voter->isConnected()) {
            $user = $voter->getUser();
        }
        
        $panier = new Panier($manager);
        $total      = $panier->total();
        $panier->verifie();
        $paniers = $panier->get();
        $produits = [];
        if  (!empty($paniers)) {
            foreach($paniers as $panier) {
                $produit = new Produit();
                $produit
                    ->setId($panier->getId())
                    ->setTitre($panier->getTitre())
                    ->setDescription($panier->getDescription())
                    ->setGenre($panier->getGenre())
                    ->setType($panier->getType());
                $produit->setQuantite($_SESSION['panier'][$panier->getId()]);
                $produits[] = $produit;
            }
        }
        
        $paniers    = $produits;
        
        return $this->render('facture/index.html.twig',[
            'paniers'       =>     $paniers,
            'total'         =>     $total,
            'user'          => $user
        ]);

    }
}