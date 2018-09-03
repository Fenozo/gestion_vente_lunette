<?php

namespace AppBundle\Engine;
use AppBundle\Entity\Prix;
use AppBundle\Entity\Stock;
use AppBundle\Entity\Facture;
use AppBundle\Entity\Mouvement;
use Doctrine\Common\Persistence\ObjectManager;


class TraitementStock {
    private $em;
    private $type;
    private $etat;
    private $quantite_total;
    private $validation = 1;

    private $produits   = [];
    private $mouvements = [];

    private $commande = null;

    public const ENTRER = 1;
    public const SORTIE = 2;

    public const TERMINER = 2;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function get($id) {
        
        $repository_facture = $this->em->getRepository(Facture::class);
        $this->commande = $repository_facture->findOneBy(['id'=> $id ,'etat' => 1]);
        if ($this->commande->getEtat() == 1) {
            $this->validation  = 1;
        } else {
            $this->validation  = self::TERMINER;
        }
        /**
         * -----------------------------------
         *  Les besoins pour les mouvements
         *  -1 stock_id
         *  -2 produit_id
         *  -3 quantite
         *  -4 prixUnitaire
         *  -5 tva
         *  -6 prixTtc
         *  -7 prixTotal
         *  -8 type
         *  -9 etat
         */
        if ($this->commande && $this->validation == 1) {

            $this->type = self::SORTIE;
            $this->etat = self::TERMINER;

            $this->CalculeStock($this->commande->getCommandes());
            $this->enregistrerTraitement();
            $this->enregistrerMouvement();

        }

        return $this->validation;
    }

    public function enregistrerTraitement() {
        /**
         *   Les besoins pour un stock
         * -1 quantité
         * -2 type
         * -3 etat
         * -4 date de création du stock
         */

        $stock = (new Stock())
            ->setQuantite($this->quantite_total)
            ->setCreatedAt(new \DateTime())
            ->setType($this->type)
            ->setEtat($this->etat);
        $this->em->persist($stock);
        $this->em->flush();
        $this->stock = $stock;
    }

    private function CalculeStock($mouvements) {
        /**
         * Le quantité du produit commandé.
         */
        $prix               = [];
        $quantite           = [];

        foreach($mouvements as $mouvement) {
            $prod = $mouvement->getProduit();
            $produit_id =  $prod->getId();
            if ($this->type == self::SORTIE) {
                $prod->setQuantite($prod->getQuantite() - $mouvement->getQuantite());
            } else if ($this->type == self::ENTRER) {
                $prod->setQuantite($prod->getQuantite() + $mouvement->getQuantite());
            }
            $repository_prix        = $this->em->getRepository(Prix::class);
            $prix[$produit_id]      =  $repository_prix->findOneBy(['produit_id' =>  $produit_id ,'etat' => 1]);
            $quantite[$prod->getId()]           =  intval($mouvement->getQuantite());
            
            $this->mouvements [] = (new Mouvement())
                ->setQuantite($quantite[$produit_id])
                ->setPrixUnitaire($prix[$produit_id]->getPrixUnitaire())
                ->setPrixTtc($prix[$produit_id]->getPrixUnitaireTtc())
                ->setPrixTotal(($prix[$produit_id]->getPrixUnitaireTtc() *  intval($quantite[$produit_id]) ))
                ->setTva($prix[$produit_id]->getTauxTva())
                ->setType($this->type)
                ->setEtat(1)
                ->setProduit( $prod );
            $this->produits[$prod->getId()] = $prod;
            $this->quantite_total += $mouvement->getQuantite();
             
        }
        

    }

    private function enregistrerMouvement() {
        $execution = 0;
        foreach($this->mouvements as $mouvement) {
            $mouvement->setStock($this->stock);
            $this->em->persist($mouvement);
            $this->em->flush($mouvement);
            if ($mouvement->getId() != null) {
                $execution += 1;
            }
        }
        if (count($this->mouvements) == $execution) {
            if ($this->type == self::SORTIE ) {
                if ($this->commande instanceof Facture) {
                    $this->commande->setEtat(self::TERMINER);
                    $this->em->persist($this->commande);
                    $this->em->flush();
                    $this->validation = self::TERMINER;
                }
            }
        }
    }

}