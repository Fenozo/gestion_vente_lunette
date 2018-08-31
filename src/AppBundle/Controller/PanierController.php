<?php

namespace AppBundle\Controller;
use AppBundle\Engine\Panier;
use AppBundle\Entity\Produit;



use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PanierController extends Controller{

    /**
     *
     * @Route("/panier", name="panier")
     */
    public function panier(ObjectManager $manager) {
        $repository_produit = $this->getDoctrine()->getRepository(Produit::class);
        $produits_db = $repository_produit->findAll();

        $produit_liste = [];
        foreach($produits_db as $produit) {
            $produit_liste[$produit->getId()] = $produit;
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
        
        return $this->render('panier/index.html.twig',[
            'paniers'    =>     $paniers,
            'total'      =>     $total,
        ]);
    }

    /**
     * @Route("/add/{id}/produit", name="panier_add")
     */
    public function add($id,ObjectManager $manager) {
       
        $repo       =   $this->getDoctrine()->getRepository(Produit::class);
        $panier     =   new Panier($manager);
        $produit    =   $repo->findOneBy(['id'=>$id]);
        $json       =   ['error'=> true];
        
        
        if  ($id) {
            if  ( empty($produit)) {
                $json['message']    =   'Ce produit n\'existe pas';
            }  else {
                $panier->add($produit->getId());
                $panier->total();
                $json['error']      =   false;
                $json['total']      =   number_format($panier->getTotalTtc(),0,'.',',');
                $json['count']      =   $panier->count();
                $json['message']    =   'Le produit à été bien ajouté à votre panier';
            }
        }  else  {
                $json['message']    =   'Vous n\'avez pas selectionné un bon produit';
        }
        
        
        return new Response(json_encode($json));
    }

    /**
     *@Route("/quantite/{id}/update", name="quantite_modifier")
     * @param integer $id
     * @return json
     */
    public function quantite_modifier($id,Request $request,ObjectManager $manager) {
        $json       =   ['error'    => true];
        $valider    =   false;
        if  ($id){
            
            if  (isset($_GET['panier_id']))  {
                $panier             =   new Panier($manager);
                $json['panier_id']  =   $_GET['panier_id'];
                $json['quantite']   =   $_GET['quantite'];
                $valider            =   $panier->update($json['panier_id'],$json['quantite'] );
                $total              =   $panier->total();
                $total              =   $panier->getTotalTtc();
                $json['total']      =   $total;
                $json['count']      =   $panier->count();
                $json['message']    =   'La quantité a bien été modifié! ';
            }
            $json['error']      =   false;
        }    else {
            $json['message']    =   'Problème';
        }
        if  ($valider == false) {
            $json['error']      =   true;
            if  (isset($_SESSION['quantite_reel'])) {
                $json['quantite_reel'] = $_SESSION['quantite_reel'][$json['panier_id']];
            }
            
        }

        return new Response(json_encode($json));
    }

    /**
     *@Route("panier/{id}/delete", name="panier_delete")
     * @param [type] $id
     * @return json
     */
    public function delete($id,ObjectManager $manager ) {
        $panier = new Panier($manager);
        $panier->del($id);
        return $this->redirectToRoute('panier');
        //return new Response(json_encode(['message'=>'Le produit a bien été supprimer']));
    }
}