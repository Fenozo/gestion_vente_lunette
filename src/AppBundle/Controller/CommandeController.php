<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Commande;
use AppBundle\Entity\Stock;
use AppBundle\Entity\Facture;

use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\User;


class CommandeController extends Controller
{

    
    /**
     *@Route("client/commande/list", name="client_commandes")
     */
    public function client_commande() {
       
        return $this->render('commande/index.html.twig', [
           
        ]);
    }

    /**
     * @Route("admin/commande/{id}/detail", name="commande_detail")
     */
    public function detail_commande(Facture $commande = null,Request $request) {
        
        if  ($request->request->count() > 0) {
            $id =  $request->request->get('commande')['id'];
            
            $traitementStock = new \AppBundle\Engine\TraitementStock(
                $this->getDoctrine()->getEntityManager()
            );
            
            $traitementStock->get($id);
        }
           
        

        return $this->render('commande/admin/show.html.twig', [
           'commande'   => $commande
        ]);
    }

    /**
     *@Route("admin/commande/list", name="admin_commandes")
     */
    public function admin_commande() {
        $repository_commande  = $this->getDoctrine()->getRepository(Facture::class);
        $commandes  = $repository_commande->findAll();
        
        return $this->render('commande/admin/index.html.twig', [
           'commandes'  => $commandes
        ]);
    }

    

}