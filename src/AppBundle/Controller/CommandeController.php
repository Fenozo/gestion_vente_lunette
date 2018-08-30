<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Lignecommande;
use AppBundle\Entity\Stock;

use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;

class CommandeController extends Controller
{


    /**
     *
     * @Route("admin/commande/list", name="admin_commande")
     */
    public function admin_liste() {
        $commandes      = [];
        $repo_commande  = $this->getDoctrine()->getRepository(Commande::class);
        $voter = $this->container->get("app.voteur");
        if ( $voter->isConnected()){
            $user       = $voter->getUser();
            $commandes  = $repo_commande->findListeCommandes();
        }
        
        return $this->render('commande/liste.html.twig', [
            'commandes'   =>  $commandes
        ]);
    }

    
    /**
     *
     * @Route("/commande/list", name="client_commande")
     */
    public function client_liste() {
        $commandes      = [];
        $repo_commande  = $this->getDoctrine()->getRepository(Commande::class);
        $voter = $this->container->get("app.voteur");
        if ( $voter->isConnected()){
            $user       = $voter->getUser();
            $commandes  = $repo_commande->findListeCommandes($user->getId());
        }
        

        return $this->render('commande/liste.html.twig', [
            'commandes'   =>  $commandes
        ]);
    }
    
    /**
     * @Route("/commande/client/{id}/detail", name="commande_detail")
     */
    public function detail_commande(Commande $commande = null,Request $request) {
        $ligne_commandes = [];

        if ($commande == null) {
            $commande = new commande();
        }
        if ($commande->getId() != null) {
            $ligne_commandes = $this->getDoctrine()
                ->getRepository(Commande::class)
                ->findLigneCommande($commande);
        }

        return $this->render('commande/detail.html.twig', [
            'ligne_commandes'           =>  $ligne_commandes
        ]);
    }
}