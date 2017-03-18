<?php


namespace MyShop\AdminBundle\ImageCheck;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\ORM\EntityManager;


class PhotoRemover extends Controller
{
   private $manager;

   private $pathDir;
   public function __construct(EntityManager $em, $pathDir )
   {
       $this->manager =$em;
       $this->pathDir = $pathDir;
   }

    public function removePhoto($photo)
    {
        $filename = $this->pathDir . $photo->getFileName();
        $smallFilename = $this->pathDir . $photo->getSmallFileName();
        $mediumFilename = $this->pathDir . $photo->getMediumFileName();
        unlink($filename);
        unlink($smallFilename);
        unlink($mediumFilename);

        $this->manager->remove($photo);
        $this->manager->flush();
    }
}