<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Faker\Factory;
use Acme\Bundle\BlogBundle\Entity\Article;
use Acme\Bundle\BlogBundle\Entity\Category;

class LoadDataActualite implements ORMFixtureInterface, OrderedFixtureInterface{

    private $categories = [
        array(
            "titre" =>'javascript',
            "description" =>'Petit cours de javascript ',
        ),
        array(
            "titre" =>'PHP',
            "description" =>'petit cours de langage PHP',
        ),
    ];

    private $articles = [
        array(
                'categoryId'  => '1',
                'titre'         => 'Les qualificateurs',
                'description'   => "Les quantificateurs permettent de dire combien de fois un caractère doit être recherché. Il est possible de dire qu'un caractère peut apparaître 0 ou 1 fois, 1 fois ou une infinité de fois, ou même, avec des accolades, de dire qu'un caractère peut être répété 3, 4, 5 ou 10 fois.",
                'createdAt'     =>'Y-m-d H:m:s'
            ),
        array(
                'categoryId'  => '1',
                'titre'         => 'Les Caractères et leurs classes',
                'description'   => "Jusqu'à présent les recherches étaient plutôt basiques. Nous allons maintenant étudier les classes de caractères qui permettent de spécifier plusieurs caractères ou types de caractères à rechercher. Cela reste encore assez simple. 
                /gr[ao]s/ 
                Une classe de caractères est écrite entre crochets et sa signification est simple : une des lettres qui se trouve entre les crochets peut convenir. Cela veut donc dire que l'exemple précédent va trouver les mots « gras » et « gros », car la classe, à la place de la voyelle, contient aux choix les lettres a et o. Beaucoup de caractères peuvent être utilisés au sein d'une classe :
                /gr[aèio]s/
                Ici, la regex trouvera les mots « gras », « grès », « gris » et « gros ». Ainsi donc, en parlant d'une tartiflette, qu'elle soit grosse ou grasse, cette regex le saura :
                
                Les intervalles de caractères
                
                Toujours au sein des classes de caractères, il est possible de spécifier un intervalle de caractères. Si nous voulons trouver les lettres allant de a à o, on écrira [a-o]. Si n'importe quelle lettre de l'alphabet peut convenir, il est donc inutile de les écrire toutes : écrire [a-z] suffit.
                
                Plusieurs intervalles peuvent être écrits au sein d'une même classe. Ainsi, la classe [a-zA-Z] va rechercher toutes les lettres de l'alphabet, qu'elles soient minuscules ou majuscules. Si un intervalle fonctionne avec des lettres, il fonctionne aussi avec des chiffres ! La classe [0-9] trouvera donc un chiffre allant de 0 à 9. Il est bien évidemment possible de combiner des chiffres et des lettres : [a-z0-9] trouvera une lettre minuscule ou un chiffre.",
                'createdAt'     =>'Y-m-d H:m:s'
            ),
        array(
                'categoryId'  => '2',
                'titre'         => "preg_match",
                'description'   => "Effectue une recherche de correspondance avec une expression rationnelle standard",
                'createdAt'     =>'Y-m-d H:m:s'
            ),
    ];

    private $category_object = [];

    public function load(\Doctrine\Common\Persistence\ObjectManager $manager)
    {
        $faker      = Factory::create('fr_FR');

        $lg_catg    =  count($this->categories);
        $lg_art     =  count($this->articles);

        for ($i = 0; $i< $lg_catg; $i++) {
            $category = (new Category())
                ->setTitre($this->categories[$i]['titre'])
                ->setDescription($this->categories[$i]['description']);
        
            $manager->persist($category);
            $manager->flush();

            array_push($this->category_object, $category);
        }
        $count = null;
        for ($art = 0; $art< $lg_art; $art++) {
            $category_key = rand(0, 1);
           
            while ($count == $category_key) {
                $category_key = rand(0, 1);
            }
            $count = $category_key ;

            $article = (new Article())
                ->setTitre($this->articles[$art]['titre'])
                ->setDescription($this->articles[$art]['description'])
                ->setCreatedAt($faker->dateTime())
                    ->setCategory($this->category_object[$category_key]);

            $manager->persist($article);
            
        }

        for ($i = $lg_art+1; $i< $lg_art+4; $i++) {
            $category_key = rand(0, 1);

            $article = (new Article())
                ->setTitre($faker->company)
                ->setDescription($faker->paragraph)
                ->setCreatedAt($faker->dateTime())
                    ->setCategory($this->category_object[$category_key]);
            
                $manager->persist($article);
                $manager->flush();
        }
    }

    public function getOrder()
    {
        return 4;
    }


}