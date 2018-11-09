<?php

namespace Acme\Bundle\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Acme\Bundle\BlogBundle\Entity\Category;
use Doctrine\ORM\EntityRepository;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titre')
        ->add('description')
        ->add('category',EntityType::class,[
            'label' => 'Category',
            'class' => Category::class,
            'query_builder' => function(EntityRepository $e) {
                return $e->createQueryBuilder('c')
                        ->orderBy('c.titre', 'ASC');
            }
            ,'choice_label' => 'titre',
        ]);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Acme\Bundle\BlogBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'acme_bundle_blogbundle_article';
    }


}
