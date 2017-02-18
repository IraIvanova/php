<?php

namespace MyShop\AdminBundle\Controller;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

use MyShop\DefaultBundle\Entity\ProductPhoto;
use MyShop\DefaultBundle\Form\ProductPhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;
use \Eventviva\ImageResize;
use MyShop\AdminBundle\ImageCheck\CheckImg;


class ProductPhotoController extends Controller
{

    
    /**
     * @Template()
    */
    public function addAction(Request $request, $idProduct)
    {
         $manager = $this->getDoctrine()->getManager();
        $product = $manager->getRepository("MyShopDefaultBundle:Product")->find($idProduct);
        if ($product == null) {
            return $this->createNotFoundException("Product not found!");
       }

        $photo = new ProductPhoto();
        $form = $this->createForm(ProductPhotoType::class, $photo);

        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $filesArray = $request->files->get("myshop_defaultbundle_productphoto");

            /** @var UploadedFile $photoFile */
            $photoFile = $filesArray["photoFile"];

            $imageCheckService = $this->get("myshop_admin.check_img");
            
            try{
            $imageCheckService->check($photoFile);

            }
            catch(\InvalidArgumentException $ex)
            {
                die("Image loading error!!!!");
            }
            
            $nameGenService = $this->get("myshop_admin.image_name_generator");
            $photoFileName = $product->getId() . $nameGenService->genName() . "." . $photoFile->getClientOriginalExtension();

            $photoDirPath = $this->get("kernel")->getRootDir() . "/../web/photos/";

            $photoFile->move($photoDirPath, $photoFileName);

            $image= new ImageResize($photoDirPath . $photoFileName);
            $image->resizeToHeight(200);
            $smallFileName= "small_". $photoFileName;
            $image->save($photoDirPath. $smallFileName);

            $image2 = new ImageResize($photoDirPath . $photoFileName);
            $image2->resizeToHeight(400);
            $mediumFileName = "medium_" . $photoFileName;
            $image2->save($photoDirPath. $mediumFileName);

            $photo->setMediumFileName($mediumFileName);
            $photo->setSmallFileName($smallFileName);
            $photo->setFileName($photoFileName);
            $photo->setProduct($product);

            $manager->persist($photo);
            $manager->flush();
        }

        return [
            "form" => $form->createView(),
            "product" => $product
        ];
           }

      
    /**
     * @Template()
     */
    public function listAction($idProduct)
    {
        $product = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Product")->find($idProduct);


        return [
            "product" => $product
        ];
    }

    /**
     * @Template()
     */
    public function editAction(Request $request,$idProduct)
    {
        $photo= $this->getDoctrine()->getRepository("MyShopDefaultBundle:ProductPhoto")
            ->find($idProduct);

        $form = $this->createForm(ProductPhotoType::class, $photo);
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($photo);
            $manager->flush();

            return $this->redirectToRoute("my_shop_admin.product_list");
        }
        return [
            "form" => $form->createView(),
            "photo" => $photo
        ];
    }


    public function deleteAction($id)
    {

        $photo= $this->getDoctrine()->getRepository("MyShopDefaultBundle:ProductPhoto")
->find($id);

        $manager = $this->getDoctrine()->getManager();
             $manager->remove($photo);
             $manager->flush();

        return $this->redirectToRoute("my_shop_admin.product_list");
    }



}