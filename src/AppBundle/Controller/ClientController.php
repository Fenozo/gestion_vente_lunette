<?php

namespace AppBundle\Controller;
use AppBundle\Engine\DB;
use AppBundle\Engine\Panier;
use AppBundle\Entity\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller{

    /**
     * Undocumented function
     *
     * @Route("/admin/clients/list", name="client_liste")
     */
    public function client_liste() {
        $repo = $this->getDoctrine()->getRepository(User::class);
        $clients = $repo->findByRoles(['roles'=>'["ROLE_CLIENT"]']);

        return $this->render('client/admin/liste.html.twig', [
            'clients'   =>  $clients
        ]);
    }

    /**
     *  @Route("admin/client/{id}/show", name="client_details")
     *
     * @param Produit $produit
     * @param Request $request
     */
    public function show(User $client) {
        //dump($client->getUserinfos()->getName());exit();
        return $this->render('client/admin/show.html.twig',[
            'client'   =>  $client,
        ]);
    }
    
}