<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FournisseurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nom',null,[
            'required'  =>  false,
            'label' =>  'Nom du fournisseur'
        ])
        ->add('marque',null,[
            'required'  =>  false,
            'label' =>  'Le Nom de marque du fournisseur'
        ])
        ->add('description',null,[
            'required'  =>  false,
            'label' =>  'description du fournisseur',
            'attr'  =>  ['placeholder'  =>  'Ici le déscription du fournisseur...']
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Fournisseur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_fournisseur';
    }


}
