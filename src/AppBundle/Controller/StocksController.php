<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Stock;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Mouvement;
use AppBundle\Entity\Prix;

use AppBundle\Form\ProduitType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class StocksController extends Controller {


    /**
     *
     * @Route("admin/stocks/list", name="stock_liste")
     */
    public function index() {
        $repository_stock         =   $this->getDoctrine()->getRepository(Stock::class);
        $stocks = $repository_stock->findAll();
        
        return $this->render('stock/admin/index.html.twig',[
            'stocks'    =>  $stocks
        ]);
    }


    /**
     *
     * @Route("admin/stocks/enter", name="stock_enter")
     * @Route("admin/stocks/enter", name="sauvegarder_stock")
     */
    public function entrer(ObjectManager $manager) {
        $repository_produit             =   $this->Repository(Produit::class);
        $repository_stock               =   $this->Repository(Stock::class);
        $repository_mouvement           =   $this->Repository(Mouvement::class);
        $repository_prix                =   $this->Repository(Prix::class);
        $tva = 0;
        $quantite_total = 0;
        $produits   = [];
        $quantite   = [];
        $prix       = [];

        /**
         * Formule : [Montant HT] x (1 + ([Taux TVA] / 100)) = [Montant TTC] 
         */

        if  (isset($_POST['ligne']['stock']))  {
            if  (count($_POST['ligne']['stock'])> 0) {

                foreach($_POST['ligne']['stock'] as $produit_id => $nb ) {
                    $prod = $repository_produit->find($produit_id);
                    if (  $prod != null  ) {
                        $prod->setQuantite($prod->getQuantite() + intval($nb));
                        $produits[$produit_id]              =  $prod;
                        $quantite_total                    +=  intval($nb);
                        $quantite[$prod->getId()]           =  intval($nb);
                        $prix[$produit_id]                  =  $repository_prix->findOneBy(['produit_id' =>  $produit_id ]);
                    }
                }

                $stock = (new Stock())
                        ->setQuantite($quantite_total)
                        ->setCreatedAt(new \DateTime())
                        ->setType(1)
                        ->setEtat(1);
                        
                $manager->persist($stock);
                $manager->flush();
                

                foreach($_POST['ligne']['stock'] as $produit_id => $nb ) {

                    if ( $prix[$produit_id]  instanceof Prix) {
                        if (isset($produits[$produit_id])) {
                            $prod = $produits[$produit_id];
                            
                            $mouvements = (new Mouvement())
                                ->setQuantite($quantite[$produit_id])
                                ->setPrixUnitaire($prix[$produit_id]->getPrixUnitaire())
                                ->setPrixTtc($prix[$produit_id]->getPrixUnitaireTtc())
                                ->setPrixTotal(($prix[$produit_id]->getPrixUnitaireTtc() *  intval($quantite[$produit_id]) ))
                                ->setTva($prix[$produit_id]->getTauxTva())
                                ->setType(1)
                                ->setEtat(1)
                                ->setProduit( $prod )
                                ->setStock( $stock ) ;
                            $manager->persist($mouvements);
                        }
                    }
                }
                $manager->flush();
            }

            return $this->redirectToRoute('stock_liste');
        }

        $produits = $repository_produit->findAll();

        $stocks     =   [];
        return $this->render('stock/admin/create.html.twig',[
            'produits'    =>  $produits
        ]);
    }

    /**
     * @Route("admin/stocks/{id}/detail", name="voir_stock")
     */
    public function show(Stock $stock) {
        
        return $this->render('stock/admin/show.html.twig',[
            'stock'         =>  $stock,
        ]);
    }

    private function Repository($entity) {
        return $this->getDoctrine()->getRepository($entity);
    }

}