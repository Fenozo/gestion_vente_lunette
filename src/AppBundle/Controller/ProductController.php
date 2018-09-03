<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Produit;
use AppBundle\Entity\Prix;

use AppBundle\Form\ProduitType;
use AppBundle\Form\PrixType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProductController extends Controller {

    /**
     * @Route("/produit", name="produit_lunette")
     */
    public function produits_pour_panier() {
        
        $repo = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repo->findAllQuantityIsNotNull();
        $filtres_produis = [];

        if  (isset($_SESSION['saturer'])) {
            if(  count($_SESSION['saturer']) >0  ) {
                foreach ($produits as $k =>  $produit) {
                    if ( isset($_SESSION['saturer'][$produit->getId()]) ) {
                        if  ($_SESSION['saturer'][$produit->getId()]  ==  1) {
                            unset($produits[$k]);
                        }
                    } else {
                        array_push($filtres_produis,$produit);
                    }
                }
            }
        }

        $upload_directory = $this->container->getParameter('upload_directory');
        $urls_images = $this->container->getParameter('urls_images');
        
       
        $prouits = $filtres_produis;
        $voter = $this->container->get("app.voteur");
        return $this->render("produit/index.html.twig",[
            'produits'          =>  $produits,
            'access'            =>  $voter->isClient(),
            'urls_images'  => $urls_images
        ]);
    }

    /**
     * @Route("admin/produit/list", name="produit_liste")
     */
    public function produit_liste() {

        $repo = $this->getDoctrine()->getRepository(Produit::class);
        $produits = $repo->findAll();
        
        return $this->render("produit/admin/list.html.twig",[
            'produits'  =>  $produits,
        ]);
    }

    /**
     * @Route("admin/produit/new", name="ajouter_produit")
     * @Route("admin/produit/{id}/edit", name="modifier_produit")
     * @Method({"GET","POST"})
     * @param Request $request
     * @param ObjectManager $manager
     * @return void
     */
    public function form(Produit $produit = null,Prix $prix = null,Request $request,ObjectManager $manager) {
        $repository_prix    = $this->getDoctrine()->getRepository(Prix::class);
        $prix_ancient       = null ;
        $voter              = $this->container->get("app.voteur");
        if (is_null($voter)) {
            return $this->redirectToRoute("produit_lunette");
        }
        if  (is_null($produit)) {
            $produit    = new Produit();
        } else {
            $image_name = $produit->getImage();
            $prix = $repository_prix->findOneBy([
                    'produit_id'=> $produit->getId(),
                    'etat'      => 1
                ]);
        }
        if ($produit->getId()) {
            $prix_ancient = $repository_prix->findOneBy([
                'produit_id'=> $produit->getId(),
                'etat'      => 1
            ]);

            $prixTtc_ancien     = $prix_ancient->getPrixUnitaireTtc();
            $unitaire_ancien    = $prix_ancient->getPrixUnitaire();
            $tva_ancien         = $prix_ancient->getTauxTva();
        }


        if  (is_null($prix)) {
            $prix = new Prix();
        }

        $urls_images = $this->container->getParameter('urls_images');



        $form_produit   = $this->createForm(ProduitType::class, $produit);
        $form_prix      = $this->createForm(PrixType::class, $prix);
        
       
        $form_produit->handleRequest($request);
        $form_prix->handleRequest($request);

        /***
         * Après une soumission d'une formulaire.
         */
        if  ( $form_produit->isSubmitted()  && $form_produit->isValid()){

            
        
            $file = $produit->getImage();

            if ($file != "") {
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                $file->move(
                    $this->container->getParameter('upload_directory'),
                    $fileName
                );
                $produit->setImage($fileName);
            } else {
                $produit->setImage($image_name);
            }
            
            if  ($produit->getId()) {
                $produit->setCreatedAt($produit->getCreatedAt());
            }   else    {
                $produit->setCreatedAt(new \DateTime());
            } 

            $manager->persist($produit);


            if ($produit->getId()) {

                if ($prix_ancient instanceof Prix) {

                    $prix_ancient
                        ->setEtat(0)
                        ->setPrixUnitaireTtc($prixTtc_ancien)
                        ->setPrixUnitaire($unitaire_ancien)
                        ->setTauxTva($tva_ancien)
                        ->setProduitId($produit->getId());

                    $manager->persist($prix_ancient);
                    $manager->flush();
                }
                dump($prix_ancient);
            }
               

            $new_prix = new Prix();
            $taux_tva           = $request->request->get('appbundle_prix')['tauxTva'];
            $prix_unitaire      = $request->request->get('appbundle_prix')['prixUnitaire'];
            $prix_ttc           = ($prix_unitaire) * (1 + ($taux_tva/100) ) ;

            $new_prix
                    ->setEtat(1)
                    ->setPrixUnitaire($prix_unitaire)
                    ->setPrixUnitaireTtc($prix_ttc)
                    ->setTauxTva($taux_tva)
                    ->setProduitId($produit->getId());

            $manager->persist($new_prix);
            $manager->flush();
            
            if  (!is_null($produit->getId())) {
                return $this->redirectToRoute('voir_produit',['id'=>$produit->getId()]);
            }
        }
        $id = ($produit->getId())? $produit->getId() : false;

        return $this->render('produit/admin/form.html.twig',[
            'form_produit'  =>  $form_produit->createView(),
            'form_prix'     =>  $form_prix->createView(),
            'modifier'      =>  ($produit->getId())? true : false,
            'id'            =>  $id
        ]);
    }

    /**
     *  @Route("produit/{id}", name="voir_produit")
     *
     * @param Produit $produit
     * @param Request $request
     */
    public function show(Produit $produit,Request $request) {
        $voter = $this->container->get("app.voteur");
        if (is_null($voter)) {
            return $this->redirectToRoute("produit_lunette");
        }

        $urls_images = $this->container->getParameter('urls_images');
        //dump($produit->getFiltreetatprix());
        return $this->render('produit/show.html.twig',[
            'produit'       =>  $produit,
            'urls_images'   =>  $urls_images
        ]);
    }

    /**
     *
     * @Route("produit/{id}/delete", name="product_delete")
     */
    public function delete(Produit $produit,ObjectManager $manager) {
        $manager->remove($produit);
        $manager->flush();

        return $this->redirectToRoute('produit_liste');
    }

    /**
     * @Route("admin/produit/api_produits", name="api_produits")
     * @Route("admin/produit/{id}/api/produit/show", name="api_show_produit")
     */
    public function api_produits(Produit $produit = null) {
        if  ($produit == null) {
            $repo = $this->getDoctrine()->getRepository(Produit::class);
            $repository_prix    = $this->getDoctrine()->getRepository(Prix::class);
            $produits = $repo->findAll();
            $api = [];

            

            foreach($produits as $produit) {

                $prix_ancient = $repository_prix->findOneBy([
                    'produit_id'=> $produit->getId(),
                    'etat'      => 1
                ]);
                    $api[] = [
                        'id'        =>  $produit->getId(),
                        'titre'     =>  $produit->getTitre(),
                        'genre'     =>  $produit->getGenre(),
                        'prix'      =>  $prix_ancient->getPrixUnitaireTtc(),
                        'quantite'  =>  $produit->getQuantite()
                    ];
            }
        } else {
            $api = [
                'id'        =>  $produit->getId(),
                'titre'     =>  $produit->getTitre(),
                'genre'     =>  $produit->getGenre(),
                'prix'      =>  $prix_ancient->getPrixUnitaireTtc(),
                'quantite'  =>  $produit->getQuantite()
            ];
        }
        return new Response(json_encode($api));
    }
}