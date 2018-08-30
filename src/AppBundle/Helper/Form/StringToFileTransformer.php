<?php
namespace AppBundle\Helper\Form;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\Produit;
class StringToFileTransformer  implements DataTransformerInterface
{
    private $file_path;
    private $image_directory = null;

    public function __construct($options = null){
        if ($options) {
            if (isset($options['file_path'])) {
                $this->file_path = $options['file_path'];
            }
        }
    }

    public function transform($file)
    {

        $produit = new Produit();

        if(!empty($file)) {
            if(file_exists($this->file_path.'/'.$file)) {
                $produit->setImage(
                    new File($this->file_path.'/'.$file)
                );
            }
        }

      
        $file = $produit->getImage()->getRealPath();
        dump($file);
        return $produit->getImage();
    }

    public function reverseTransform($file)
    {
        return $file;
    }

   
}