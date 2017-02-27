<?php


namespace MyShop\AdminBundle\ImageCheck;


use Doctrine\ORM\EntityManager;
use MyShop\DefaultBundle\Form\ProductPhotoType;

class PhotoRemover
{
   private $manager;

   private $pathDir;
   public function __construct(EntityManager $em, $pathDir )
   {
       $this->manager =$em;
       $this->pathDir = $pathDir;
   }

    public function removePhoto($pathDir, $photoFileName)
    {

        $photoFile= $pathDir . $photoFileName;
        $smallFileName= "small_". $photoFileName;
        $mediumFileName = "medium_". $photoFileName;
        $smallPhotoFile= $pathDir . $smallFileName;
        $mediumPhotoFile = $pathDir . $mediumFileName;

        unlink($photoFile);

        unlink($smallPhotoFile);

        unlink($mediumPhotoFile);




    }
}