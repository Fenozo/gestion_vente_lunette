<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Entity\UserInfos;

use AppBundle\Form\RegistrationType;
use AppBundle\Form\UserInfosType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{


    /**
     * @Route("/inscription", name="security_registration")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user               =   new User();
        $userInfos          =   new UserInfos();
        $form               =   $this->createForm(RegistrationType::class,$user);
        $form_userInfos     =    $this->createForm(UserInfosType::class,$userInfos);
        $form->handleRequest($request);
        $form_userInfos->handleRequest($request);

        if   ($form->isSubmitted() && $form->isValid() && $form_userInfos->isSubmitted() && $form_userInfos->isValid() ) {

            
                $hash = $encoder->encodePassword($user, $user->getPassword());

                $user->setPassword($hash)
                    ->setRoles(['ROLE_CLIENT'])
                    ->setEmail($userInfos->getEmail())
                    ->setUserinfos(
                        (new \AppBundle\Entity\UserInfos())
                        ->setName($userInfos->getName())
                        ->setPrename($userInfos->getPrename())
                        ->setEmail($userInfos->getEmail())
                        ->setAdress($userInfos->getAdress())
                        ->setPhone($userInfos->getPhone())
                    );

                $manager->persist($user);
                $manager->flush();
                if ($user->getId()) {
                    $this->addFlash(
                        'notice',
                        'Vous compte est bien enregistré!'
                    );
                } 
                return $this->redirectToRoute("security_login");
        }

        // replace this example code with whatever you need
        return $this->render('security/registration.html.twig',[
            'form'              =>  $form->createView(),
            'form_userInfos'    => $form_userInfos->createView()
        ]);
    }

    /**
     *
     * @Route("connexion", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        
        return $this->render("security/login.html.twig", array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
    /**
     *
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout() {
        return '';
    }

}
