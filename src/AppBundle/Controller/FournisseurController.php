<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Fournisseur;

use AppBundle\Form\FournisseurType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class FournisseurController extends Controller {

    /**
     *
     * @Route("admin/fournisseur/list", name="fournisseur_liste")
     */
    public function index() {
        $repo = $this->getDoctrine()->getRepository(Fournisseur::class);
        $fournisseurs = $repo->findAll();
        return $this->render('fournisseur/admin/list.html.twig',[
            'fournisseurs'    =>  $fournisseurs
        ]);
    }

    /**
     * @Route("admin/fournisseur/new", name="ajouter_fournisseur")
     * @Route("admin/fournisseur/{id}/edit", name="modifier_fournisseur")
     * @Method({"GET","POST"})
     * @param Request $request
     * @param ObjectManager $manager
     * @return void
     */
    public function form(fournisseur $fournisseur = null,Request $request,ObjectManager $manager) {

        if  (is_null($fournisseur)) {
            $fournisseur = new Fournisseur();
        }
        
        $form_fournisseur = $this->createForm(fournisseurType::class, $fournisseur);
        $form_fournisseur->handleRequest($request);

        if  ( $form_fournisseur->isSubmitted()  && $form_fournisseur->isValid()){
            if  ($fournisseur->getId()) {
                $fournisseur->setCreatedAt($fournisseur->getCreateAt());
            }   else    {
                $fournisseur->setCreatedAt(new \DateTime());
            }
            $manager->persist($fournisseur);
            $manager->flush();
            if  (!is_null($fournisseur->getId())) {
                return $this->redirectToRoute('voir_fournisseur',['id'=>$fournisseur->getId()]);
            }
        }
        $id = ($fournisseur->getId())? $fournisseur->getId() : false;

        return $this->render('fournisseur/admin/form.html.twig',[
            'form_fournisseur'  =>  $form_fournisseur->createView(),
            'modifier'      =>  ($fournisseur->getId())? true : false,
            'id'            =>  $id
        ]);
    }
    /**
     *  @Route("admin/fournisseur/{id}", name="voir_fournisseur")
     *
     * @param Produit $produit
     * @param Request $request
     */
    public function show(Fournisseur $fournisseur,$id, Request $request) {
        return $this->render('fournisseur/show.html.twig',[
            'fournisseur'   =>  $fournisseur,
        ]);
    }
    
    /**
     *
     * @Route("admin/fournisseur/{id}/delete", name="fournisseur_delete")
     */
    public function delete(Fournisseur $Fournisseur,ObjectManager $manager) {
        $manager->remove($Fournisseur);
        $manager->flush();

        return $this->redirectToRoute('founisseur_list');
    }
}