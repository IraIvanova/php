<?php


namespace MyShop\AdminBundle\ImageCheck;


use Doctrine\ORM\EntityManager;
use MyShop\DefaultBundle\Form\ProductPhotoType;

class PhotoRemover
{

    private $manager;
    private $pathDir;

    public function __construct(EntityManager $em, $pathDir)
    {
        $this->manager = $em;
        $this->pathDir= $pathDir;
    }

    public function removePhoto($photoFileName)
    {

        $manager->remove($photo);
        $manager->flush();
    }
}