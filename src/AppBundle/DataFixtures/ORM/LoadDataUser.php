<?php
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Client;
use AppBundle\Entity\User;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadDataUser extends AbstractFixture  implements ORMFixtureInterface, OrderedFixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager) {
        
        $personne = self::personne();

        for ( $i= 0; $i< count($personne); $i++) {
            //$c = mt_rand(0,1);
            $user = new User();

            $encoder = $this->container->get('security.password_encoder');

            $hash = $encoder->encodePassword($user,$personne[$i]['password']);
            
            $user
            ->setPassword($hash)
            ->setConfirmPassword($hash)
            ->setRoles($personne[$i]['role'])
            ->setEmail($personne[$i]['email'])
            ->setUserinfos(
                (new \AppBundle\Entity\UserInfos())
                    ->setName($personne[$i]['nom'])
                    ->setPrename($personne[$i]['prenom'])
                    ->setEmail($personne[$i]['email'])
                    ->setAdress($personne[$i]['adresse'])
                    ->setPhone($personne[$i]['telephone'])
                );

            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getOrder()
    {
        // the order in which fixtures will be loaded
        // the lower the number, the sooner that this fixture is loaded
        return 2;
    }

    public static function personne() {
        return  [
            [
                'nom'           => 'Ranivoarisoa1',
                'prenom'        => 'Jimmy',
                'email'         => 'jimmy@gmail.com',
                'adresse'       => 'Ampitatafika Lot BM 65 Atsimombohitra',
                'telephone'     => '0347031707',
                'role'          => ['ROLE_ADMIN'],
                'password'      => 'admin131',
            ],
            [
                'nom'           => 'Ranivoarisoa',
                'prenom'        => 'Jimmy',
                'email'         => 'jrnvrs2@gmail.com',
                'adresse'       => 'Ampitatafika Lot BM 65 Atsimombohitra',
                'telephone'     => '0347031707',
                'role'          => ['ROLE_ADMIN'],
                'password'      => 'admin121',
            ],
            [
                'nom'           => 'Rakotosoa',
                'prenom'        => 'Feno Zo Tahina',
                'email'         => '960gd7@gmail.com',
                'adresse'       => 'Manandriana Avaradrano',
                'telephone'     => '0348847626',
                'role'          => ['ROLE_ADMIN'],
                'password'      => 'admin771',
            ],
            [
                'nom'           => 'Ranaivoarisoa',
                'prenom'        => 'Jimmy',
                'email'         => 'jrnvrs@gmail.com',
                'adresse'       => 'Ampitatafika Lot BM 65',
                'telephone'     => '0347031707',
                'role'          => ['ROLE_CLIENT'],
                'password'      => 'client21',
            ],
            [
                'nom'           => 'Andriamialy',
                'prenom'        => 'Nissaina Angelot',
                'email'         => 'jrnvrs1@gmail.com',
                'adresse'       => 'Ampitatafika Lot BM 65',
                'telephone'     => '0347031707',
                'role'          => ['ROLE_CLIENT'],
                'password'      => 'client1',
            ]
        ];
    }
}