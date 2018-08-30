<?php
// src/AppBundle/DataFixtures/ORM/LoadFixtures.php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Produit;
use AppBundle\Entity\Fournisseur;
use AppBundle\Entity\Prix;

use Faker\Factory;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
class LoadDataProduit implements ORMFixtureInterface ,OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {

       
        $prduits            = self::load_product();
        $faker              =   Factory::create('fr_FR');
        $data_fournisseur   = [];

        for ($i = 0; $i < 5 ; $i++) {
            $founisseur = (new Fournisseur())
                ->setNom($faker->firstName())
                ->setMarque($faker->company)
                ->setDescription($faker->paragraph())
                ->setCreatedAt($faker->dateTime());

            $manager->persist($founisseur);
            $manager->flush();
            $data_fournisseur[] = $founisseur;
        }

        for ($i = 0; $i < count($prduits); $i++) {
            
            $product = (new Produit())
                ->setTitre($prduits[$i]['name'])
                ->setDescription($faker->text)
                ->setType($prduits[$i]['type'])
                ->setGenre($prduits[$i]['genre'])
                ->setImage($prduits[$i]['url'])
                ->setCreatedAt($faker->dateTime());

            $founisseur = $data_fournisseur[mt_rand( 0, (count($data_fournisseur)-1) )];
            $product->setFournisseur($founisseur);
            
            $manager->persist($product);
            $manager->flush();

            $tva = 20;
            $prixTtc = ($prduits[$i]['prix']) * (1 + ($tva/100) ) ;

            $prix = (new Prix()) 
                ->setPrixUnitaire($prduits[$i]['prix'])
                ->setTauxTva($tva)
                ->setPrixUnitaireTtc($prixTtc)
                ->setEtat(1)
                ->setProduitId($product->getId());
        
            $manager->persist($prix);
            $manager->flush();
        }
        
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 1;
    }

    //assets/coloShop/images
    public static function load_product() {

        /**
         * - Un produit est constitué de : 
         *  titre,
         *  description,
         *  Quantité en Stock, 
         *  marque,
         *  Prix ttc,
         *  types (1:soleil, 2:vue, 3:sport), 
         *  genre (1:homme, 2:femme, 3:mixte, 4:enfant)
         */

        return [
            [
                'url'   =>  'mixte_product_4.jpg',
                'genre' =>  3,
                'name'  =>  'Aviator Optics',
                'prix'  =>  '168.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [
                'url'   =>  'mixte_product_3.jpg',
                'genre' =>  3,
                'name'  =>  'Round double bridg',
                'prix'  =>  '188.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [
                'url'   =>  'mixte_product_2.jpg',
                'genre' =>  3,
                'name'  =>  'Pryma Headphones, Rose Gold & Grey',
                'prix'  =>  '180.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'mixte_product_1.jpg',
                'genre' =>  3,
                'name'  =>  'Pryma Headphones, Rose Gold & Grey',
                'prix'  =>  '180.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ]
            ,
            [  
                'url'   =>  'mixte_product_1.jpg',
                'genre' =>  3,
                'name'  =>  'Pryma Headphones, Rose Gold & Grey',
                'prix'  =>  '850.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'men_product_6.png',
                'genre' =>  1,
                'name'  =>  'Pryma Headphones, Rose Gold & Grey',
                'prix'  =>  '200.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'women_product_10.jpeg',
                'genre' =>  2,
                'name'  =>  'Pryma Headphones, Rose Gold & Grey',
                'prix'  =>  '500.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'children_product_9.jpg',
                'genre' =>  4,
                'name'  =>  'DYMO LabelWriter 450 Turbo Thermal Label Printer',
                'prix'  =>  '410.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'children_product_8.jpg',
                'genre' =>  4,
                'name'  =>  'Blue Yeti USB Microphone Blackout Edition',
                'prix'  =>  '120.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'product_7.png',
                'genre' =>  2,
                'name'  =>  'Ray Ban',
                'prix'  =>  '610.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'women_product_1.jpg',
                'genre' =>  2,
                'name'  =>  'Ray Ban',
                'prix'  =>  '610.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'product_5.jpg',
                'genre' =>  2,
                'name'  =>  'Lunette à monture simple',
                'prix'  =>  '310.00',
                'desc'  =>  'Description',
                'type'  =>  2
            ],
            [  
                'url'   =>  'product_1.jpg',
                'genre' =>  1,
                'name'  =>  'Ray Ban',
                'prix'  =>  '310.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'product_2.jpg',
                'genre' =>  2,
                'name'  =>  'Ray Ban',
                'prix'  =>  '310.00',
                'desc'  =>  'Description',
                'type'  =>  1
            ],
            [  
                'url'   =>  'product_3.jpg',
                'genre' =>  1,
                'name'  =>  'Lunette simple',
                'prix'  =>  '120.00',
                'desc'  =>  'Description',
                'type'  =>  2
            ],
            [  
                'url'   =>  'women_product_4.jpg',
                'genre' =>  2,
                'name'  =>  'Lunette simple',
                'prix'  =>  '120.00',
                'desc'  =>  'Description',
                'type'  =>  2
            ]

            
        ];
    }
}
