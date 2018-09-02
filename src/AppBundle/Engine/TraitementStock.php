<?php

namespace AppBundle\Engine;
use Doctrine\Common\Persistence\ObjectManager;


class TraitementStock {
    private $em;

    public const ENTRER = 1;
    public const SORTIE = 2;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }


}