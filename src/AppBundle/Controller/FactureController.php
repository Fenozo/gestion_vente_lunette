<?php

namespace AppBundle\Controller;
use AppBundle\Engine\Panier;
use AppBundle\Entity\Produit;
use AppBundle\Entity\User;
use AppBundle\Entity\Prix;
use AppBundle\Entity\Facture;
use AppBundle\Entity\Commande;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FactureController extends Controller{

    /**
     *
     * @Route("client/valider", name="valider_panier")   
     */
    public function valider_panier( ObjectManager $manager, Request $request ) {

        $repository_produit = $this->getDoctrine()->getRepository(Produit::class);
        $repository_prix = $this->getDoctrine()->getRepository(Prix::class);
        $produits_db = $repository_produit->findAll();

        $produit_liste = [];
        foreach($produits_db as $produit) {
            $produit_liste[$produit->getId()] = $produit;
        }

        $total          = 0;
        $nobre_produit  = 0;

        $voter = $this->container->get("app.voteur");
        
        if  ($voter->isClient() != 3 && $voter->isConnected()) {
            //dump($request->request);
            return $this->redirectToRoute('commande_detail',['id'=>$commnade->getId()]);
            // (new Panier())->removeAll();
        }
        $user = new User();
        if ($voter->isConnected()) {
            $user = $voter->getUser();
        }
        
        $panier = new Panier($manager);
        $total      = $panier->total();
        $total      = $panier->getTotalTtc();
        $panier->verifie();
        $paniers = $panier->get();
        $produits = [];
        if  (!empty($paniers)) {
            foreach($paniers as $panier) {
                $produit = $produit_liste[$panier->getId()];
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

    /**
     *
     * @Route("client/valider/commande", name="valider_commande")   
     */
    public function valider_commande(ObjectManager $manager,Request $request) {
        $success            = false;
        $repository_produit = $this->getDoctrine()->getRepository(Produit::class);
        $repository_facture = $this->getDoctrine()->getRepository(Facture::class);
        $repository_prix    = $this->getDoctrine()->getRepository(Prix::class);
        $produits_db        = $repository_produit->findAll();
        $nombre_facture     = $repository_facture->count();

        $produit_liste = [];
        foreach($produits_db as $produit) {
            $produit_liste[$produit->getId()] = $produit;
        }

        $total          = 0;
        $nobre_produit  = 0;

        $voter = $this->container->get("app.voteur");
        
        if  ($voter->isClient() != 3 && $voter->isConnected()) {

            return $this->redirectToRoute('home');
        }
        $user = new User();
        if ($voter->isConnected()) {
            $user = $voter->getUser();
        }

        $panier = new Panier($manager);
        $total      = $panier->total();
        $total      = $panier->getTotalTtc();

        $facture = new Facture();
        
        $facture
            ->setUser($voter->getUser())
            ->setPrixTotal($total)
            ->setNumeroFacture( 'F'.str_pad(($nombre_facture + intval(1)), 4, "0", STR_PAD_LEFT).'/'.date('Y').''.date('m') )
            ->setNumeroCommande( 'C'.str_pad(($nombre_facture + intval(1)), 4, "0", STR_PAD_LEFT).'/'.date('Y').''.date('m'))
            ->setYears(date('Y'))
            ->setMonth(date('m'))
            ->setCreatedAt(new \Datetime());

        $manager->persist($facture);
        $manager->flush();

        if ($request->request->count() >0) {

            if (isset($request->request->get('panier')['quantite']) ) {
                $prod = $request->request->get('panier')['quantite'];

                foreach ($prod as $produit_id => $quantite) {

                    $produit = $produit_liste[$produit_id];

                    if ( $produit->getQuantite() >= $quantite) {
                        $produit->setQuantite($quantite);
                    } else {
                        $produit->setQuantite($produit->getQuantite());
                    }

                    $prix = $repository_prix->findOneBy(['produit_id' => $produit_id , 'etat' => 1 ]) ;
                    
                    $produits[] = $produit;
                    
                    $prix_unitaire  = $prix->getPrixUnitaire();
                    $taux_tva       = $prix->getTauxTva();
                    $prix_ttc       = ($prix_unitaire) * (1 + (intval($taux_tva)/100) ) ;
                    $prix_total     = intval($prix_ttc) * intval($quantite);
                $commande = (new Commande())
                    ->setPrixUnitaire($prix->getPrixUnitaire())
                    ->setPrixUnitaireTtc($prix_ttc)
                    ->setTauxTva($prix->getTauxTva())
                    ->setprixTotal($prix_total)
                    ->setQuantite($quantite)
                    ->setCreatedAt(new \DateTime())
                    ->setEtat(1)
                    ->setProduit($produit)
                    ->setFacture($facture);

                $manager->persist($commande);
                $manager->flush();
                $success = true;
                }
            }
        }

        if ($success == true) {
            (new Panier())->removeAll();
            $this->addFlash(
                'notice',
                'Votre commande est enregistrée!'
            );
        } else {
            $this->addFlash(
                'notice',
                ' Votre commande n\'a pas pu être enregistrée!'
            );
        }

        return  $this->redirectToRoute('client_commandes');

    }
}