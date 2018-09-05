<?php

namespace AppBundle\Engine;
use AppBundle\Entity\Prix;
use AppBundle\Entity\Produit;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;


class TraitementProduit {

    private $em;
    private $container;

    public function __construct(ObjectManager $em,ContainerInterface $container)
    {
         $this->em = $em;
         $this->container = $container;
    }


    public function run($produit,$prix_ancient) {
        
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

                    $prix_ancient_courant = $prix_ancient;

                    $prix_ancient_courant
                        ->setEtat(0)
                        ->setProduitId($produit->getId());

                    $manager->persist($prix_ancient_courant);
                    $manager->flush();
                }
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
    }
}