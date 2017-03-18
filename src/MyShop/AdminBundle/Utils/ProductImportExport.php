<?php

namespace MyShop\AdminBundle\Utils;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use MyShop\DefaultBundle\Entity\Product;

class ProductImportExport
{

    /***
     * @var EntityManager
     */
 private $manager;
 private $kernel;

 public function __construct(EntityManagerInterface $manager, $kernel)
 {
     $this->manager = $manager;
     $this->kernel = $kernel;
 }


 public function exportProduct()
 {
     $products=$this->manager->createQuery("select p from MyShopDefaultBundle:Product p")->getResult();


     $iconFilePath= $this->kernel->getRootDir(). "/../src/MyShop/photo/";
     $loadImagePath = $this->kernel->getRootDir(). "/../web/photos/";

     $csv= "model,description,price, iconFileName"."\n";

     /**@var Product $product*/
     foreach($products as $product)
     {
         $csv .= $product->getModel() . "," . $product->getDescription() . "," . $product->getPrice() . "," . $product->getIconFileName(). "\n";
       if ($product->getIconFileName()) {
           copy($loadImagePath . $product->getIconFileName(), $iconFilePath . $product->getIconFileName());
       }
       }

     return $csv;
 }

 public  function parseCcvData($filePath)
 {

     $iconFilePath= $this->kernel->getRootDir(). "/../src/MyShop/photo/";
     $loadImagePath = $this->kernel->getRootDir(). "/../web/photos/";

     $fh = fopen($filePath, "r");



     fgetcsv($fh);

     while(($data = fgetcsv($fh)) != false ){


             $product = new Product();
             $product->setModel($data[0]);
             $product->setDescription($data[1]);
             $product->setPrice($data[2]);
             $product->setIconFileName($data[3]);
             copy($iconFilePath .$data[3], $loadImagePath. $data[3]);
             $product->setMainPhotoFileName("xdfdg.png");
             $this->manager->persist($product);
             $this->manager->flush();

     }
     fclose($fh);
 }

}
//// myshop_admin.product_import_export:
//class:   MyShop\AdminBundle\Utils\ProductImportExport
//          arguments:
//             - "@doctrine.orm.entity_manager" ?????????????????????????????????.jpg