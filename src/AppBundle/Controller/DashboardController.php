<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Stock;

use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\Alice\support\models\User;

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
        
        $repo_produit       = $this->getDoctrine()->getRepository(Produit::class);
        $repo_stock         = $this->getDoctrine()->getRepository(Stock::class);
        $produits_dispo     = $repo_produit->countAllQuantityIsNotNull();

        $stock_disponible   = 0;
        if (!empty($produits_dispo))  {
            $stock_disponible = $produits_dispo[0][1];
        }
        $dernier_stock = $repo_stock->findLastStockOrderByDate();
        $dernier_stock = (count($dernier_stock)>0) ? $dernier_stock[0] : new Stock();
        // replace this example code with whatever you need
        return $this->render('dashboard/index.html.twig',[
            'stock_disponible'     =>   $stock_disponible,
            'dernier_stock'        =>   $dernier_stock,
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
