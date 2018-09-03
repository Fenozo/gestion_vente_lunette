<?php

namespace AppBundle\Controller;
use AppBundle\Engine\Dates;
use AppBundle\Entity\Stock;

use AppBundle\Entity\Facture;
use AppBundle\Entity\Produit;
use Nelmio\Alice\support\models\User;
use AppBundle\Engine\StatistiqueCommande;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{

    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        $voter = $this->container->get("app.voteur");
        if ($voter != null ) {
            if  ($voter->isAdmin() == 3) {
                return $this->redirectToRoute("dashboard");
            }
        }
        
        // replace this example code with whatever you need
        return $this->render('home/index.html.twig');
    } 
    /**
     * @Route("admin/", name="dashboard")
     */
    public function dashboard()
    {
        $repository_produit     = $this->getDoctrine()->getRepository(Produit::class);
        $repository_stock       = $this->getDoctrine()->getRepository(Stock::class);
        $repository_factutre       = $this->getDoctrine()->getRepository(Facture::class);
        $produits_dispo         = $repository_produit->countAllQuantityIsNotNull();
        
        $stock_dispo    = 0;
        $produits       = [];

        if (!empty($produits_dispo))  {
            foreach ($produits_dispo  as $prod) {
                $stock_dispo += $prod->getQuantite();
                $produits[$prod->getId()] = $prod->getId();
            }
        }



        // Enter des produits
        $dernier_entrer = $repository_stock->findOneBy([
            'type'  => 1,
            'etat'  => 1,

        ], array('id' => 'DESC'));

        if (empty($dernier_entrer)) {
                
            $dernier_entrer =  new Stock();
        }

        $entrer_total = 0;
        $entrer_totals = $repository_stock->findBy([
            'type'  => 1,
            'etat'  => 1,

        ], array('id' => 'DESC'));

        foreach($entrer_totals as $entrers) {
            $entrer_total += $entrers->getQuantite();
        }

        // Sortie des produits
        $sortie_courrant = $repository_stock->findOneBy([
            'type'  => 2,
            'etat'  => 2,
            
        ], array('id' => 'DESC'));

        if (empty($sortie_courrant)) {
            $sortie_courrant = new Stock();
        }

        $date1 = $sortie_courrant->getCreatedAt();
        $date2 = $dernier_entrer->getCreatedAt();

   
        if (Dates::compare($date1,"<=",$date2)) {
            $date_stock = $date2;
        } else {
            $date_stock = $date1;
        }
        

        $sortie_totals = $repository_stock->findBy([
            'type'  => 2,
            'etat'  => 2,
            
        ], array('id' => 'DESC'));

        $sortie_total = 0;

        if (!empty($sortie_totals)) {
            foreach($sortie_totals as $sorties ) {
                $sortie_total  += $sorties->getQuantite();
            }
        }

        // Gestion des sorties
        $sorties = $repository_stock->findBy([
            'type'  => 2

        ], array('id' => 'DESC'));

        $sorties_invalider = [];
        $sorties_valider = [];
        
        foreach($sorties as $sortie) {
            if ($sortie->getEtat() == 1) {
                $sorties_invalider[] = $sortie;
            } else {
                $sorties_valider[] = $sortie;
            }
        }

        $comm = new StatistiqueCommande();
        $comm->init($sorties);
        dump($comm->pourcentage());

        $different_produit_disponible = count($produits);

        return $this->render('dashboard/index.html.twig',[
            'stock_disponible'      => $stock_dispo,
            'dernier_entrer'        => $dernier_entrer,
            'sortie_courrant'       => $sortie_courrant,
            'entrer_total'          => $entrer_total,
            'sortie_total'          => $sortie_total,
            'date_stock'            => $date_stock,
            'different_produit_disponible'=> $different_produit_disponible,
        ]);

    } 

    /**
     * Undocumented function
     *
     * @Route("/test", name="test1")
     */
    public function test() {
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

}
