<?php

namespace AppBundle\Engine;
use Doctrine\Common\Persistence\ObjectManager;
class Panier {
    private $em;
    function __construct($em = null) 
    {
        if  (!isset($_SESSION)) {
            session_start();
        }
        if  (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = array();
        }
        if  (!isset($_SESSION['saturer'])) {
            $_SESSION['saturer'] = array();
        }
        if  (!isset($_SESSION['quantite_reel'])) {
            $_SESSION['quantite_reel'] = array();
        }
        $this->em = $em;
        $this->verifie();
        
    }

    public function add($produit_id) {
       

        if  (isset($_SESSION['panier'][$produit_id])) {
            $query = $this->em->createQuery(
                'SELECT p.id, p.quantite
                FROM  AppBundle\Entity\Produit p
                WHERE p.id = ('.$produit_id.')
                '
            );
            $datas = $query->execute();
            if  ($datas[0]['quantite']  >=  $_SESSION['panier'][$produit_id]) {
                $_SESSION['panier'][$produit_id] += intval(1);
                $_SESSION['saturer'][$produit_id] = 0;
            } else {
                $_SESSION['saturer'][$produit_id] = 1;
                return false;
            }
        } else {
            $_SESSION['panier'][$produit_id] = 1;
        }
    }
    public function update($produit_id,$quantite) {
        $query = $this->em->createQuery(
            'SELECT p.id, p.quantite
            FROM  AppBundle\Entity\Produit p
            WHERE p.id = ('.$produit_id.')
            '
        );
        $datas = $query->execute();
        if  ($datas[0]['quantite']  >=  $quantite) {
            $_SESSION['panier'][$produit_id]            =  intval($quantite);
            $_SESSION['saturer'][$produit_id] = 0;
            return true;
        } else {
            $_SESSION['saturer'][$produit_id] = 1;
            return false;
        }
        
    }
    public function verifie() {
        $paniers = $this->isPanier();
        if  ($paniers) {
            $ids = array_keys($paniers);
            if  (is_array($ids) && !empty($ids)) {
                if  (!empty($this->em)) {
                    foreach ($ids as $produit_id) {
                        $query = $this->em->createQuery(
                            'SELECT prod.id,prod.quantite, p.prixUnitaire as prix, p.produit_id
                            FROM  AppBundle\Entity\Produit prod
                            LEFT JOIN AppBundle\Entity\Prix p
                            WITH prod.id = p.produit_id
                            WHERE p.id = ('. $produit_id.')
                            '
                        );
        

                        $datas = $query->execute();
                        
                        $_SESSION['quantite_reel'][$produit_id] = $datas[0]['quantite'];
                        if  (   intval($datas[0]['quantite'])  ==  intval($_SESSION['panier'][$produit_id])  ) {
                                $_SESSION['saturer'][$produit_id] = 1;
                        } else if ( intval($datas[0]['quantite'])  >  intval($_SESSION['panier'][$produit_id]) ) {
                            $_SESSION['saturer'][$produit_id] = 0;
                        }

                        if  (empty($datas)) {
                            $this->del($produit_id);
                        }
                    }
                    
                }
            } 
        }
    }

    public function get(){
        if($this->isPanier()) {

            $ids = array_keys($_SESSION['panier']);
            
            $query = $this->em->createQuery(
                'SELECT p
                FROM AppBundle\Entity\Produit p
                WHERE p.id IN ('.implode(',', $ids).')
                '
            );
            // returns an array of Product objects
            return $query->execute();
        }
    }
    public function count() {
        return array_sum($_SESSION['panier']);
    }

    public function total() {
        
        $total = 0;
        if(isset($_SESSION['panier'])) {

            $ids = array_keys($_SESSION['panier']);
            if (count($ids) > 0) {
                $query = $this->em->createQuery(
                    'SELECT prod.id, p.prixUnitaire as prix, p.produit_id
                    FROM  AppBundle\Entity\Produit prod
                    LEFT JOIN AppBundle\Entity\Prix p
                    WITH prod.id = p.produit_id
                    WHERE prod.id IN ('.implode(',', $ids).')
                    '
                );
                $produits = $query->execute();
                
                foreach ($produits as  $produit) {
                    $total += $produit['prix'] * intval($_SESSION['panier'][$produit['id']]);
                }
            }

        }
        
        return $total;
    }

    public function del($produit_id) {
        if  (isset($_SESSION['panier'][$produit_id]))  {
            unset($_SESSION['panier'][$produit_id]);
            unset($_SESSION['saturer'][$produit_id]);
        }
    }
    public function removeAll() {
        if  (isset($_SESSION['panier']))  {
            unset($_SESSION['panier']);
            unset($_SESSION['saturer']);
        }
    }
    private function isPanier() {
        if  (isset($_SESSION['panier'])){
            $ids = $_SESSION['panier'];
            return (!empty($ids)) ? $ids : false;
        } else {
            return false;
        }
    }
}