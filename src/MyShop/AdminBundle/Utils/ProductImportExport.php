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

 public function __construct(EntityManagerInterface $manager)
 {
     $this->manager = $manager;
 }


 public function exportProduct()
 {
     $products=$this->manager->createQuery("select p from MyShopDefaultBundle:Product p")->getResult();

     $csv= "model,description,price"."\n";

     /**@var Product $product*/
     foreach($products as $product)
     {
         $csv .= $product->getModel() . "," . $product->getDescription() . "," . $product->getPrice() . "," . $product->getIconFileName(). "\n";
     }

     return $csv;
 }

 public  function parseCcvData($filePath)
 {
     $fh = fopen($filePath, "r");

     while(($data = fgetcsv($fh)) != false ){


             $product = new Product();
             $product->setModel($data[0]);
             $product->setDescription($data[1]);
             $product->setPrice($data[2]);

           //  $product->setIconFileName("346546.jpg");
             //$product->getMainPhotoFileName("xdfdg.png");
             var_dump($product);
             die();
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