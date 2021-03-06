<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Helper\Form\StringToFileTransformer;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Repository\FournisseurRepository;

use AppBundle\Entity\Fournisseur;
use Doctrine\ORM\EntityRepository;

class ProduitType extends AbstractType
{   


    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('fournisseur',EntityType::class,[
            'required'  =>  false,
            'label'=>'Marque',
            'class' => Fournisseur::class,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('f')
                    ->orderBy('f.nom', 'ASC');
            },
            'choice_label' => 'marque',
        ])
        ->add('titre',null,[
            'required'  =>  false
        ])
        ->add('image',FileType::class, array(
            'data_class'    => null,
            'required'      => false
            ))
        ->add('description',TextareaType::class,[
            'required'  =>  false
        ])
        ->add('type', ChoiceType::class, array(
            'choices'  => array(
                'Soleil' => 1,
                'Vue' => 2,
                'Sport' => 3,
            )
        ))
        ->add('genre', ChoiceType::class, array(
            'choices'  => array(
                'Homme' => 1,
                'Femme' => 2,
                'Mixtes' => 3,
                'Enfant' => 4,
            )
        ));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Produit'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_produit';
    }


}
