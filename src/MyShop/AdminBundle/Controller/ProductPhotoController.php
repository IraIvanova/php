<?php

namespace MyShop\AdminBundle\Controller;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

use MyShop\AdminBundle\MyShopAdminBundle;
use MyShop\DefaultBundle\Entity\ProductPhoto;
use MyShop\DefaultBundle\Form\ProductPhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;




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

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);
            $filesArray = $request->files->get("myshop_defaultbundle_productphoto");

            /** @var UploadedFile $photoFile */
            $photoFile = $filesArray["photoFile"];

            $imageCheckService = $this->get("myshop_admin.check_img");

            try {
                $imageCheckService->check($photoFile);

            } catch (\InvalidArgumentException $ex) {
                die("Image loading error!!!!");
            }

            $result = $this->get("myshop_admin.image_uploader")->uploadImage($photoFile, $idProduct);

            $photo->setMediumFileName($result->getMediumFileName());
            $photo->setSmallFileName($result->getSmallFilename());
            $photo->setFileName($result->getBigFileName());
            $photo->setProduct($product);

            $manager->persist($photo);
            $manager->flush();

            $session= $this->get('session');
            $session->set('notification', $this->get('session')->get('notification') . "product photo added. ");
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
    public function editAction(Request $request, $id)
    {
        $photo = $this->getDoctrine()->getRepository("MyShopDefaultBundle:ProductPhoto")->find($id);

        //$product = $photo->getProduct();


        $form = $this->createForm(ProductPhotoType::class, $photo);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            $filesArray = $request->files->get("myshop_defaultbundle_productphoto");


            /** @var UploadedFile $photoFile */
            $photoFile = $filesArray["photoFile"];

            $imageCheckService = $this->get("myshop_admin.check_img");

            try {
                $imageCheckService->check($photoFile);

            } catch (\InvalidArgumentException $ex) {
                die("Image loading error!!!!");
            }

            $result = $this->get("myshop_admin.image_uploader")->uploadImage($photoFile, $id);

            $photo->setMediumFileName($result->getMediumFileName());
            $photo->setSmallFileName($result->getSmallFilename());
            $photo->setFileName($result->getBigFileName());

            $photo->setProduct($product);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($photo);
            $manager->flush();
        }

        return [
            "form" => $form->createView(),
            //"product" => $product,
            "photo" => $photo
        ];
    }

    public function deleteAction($id)
    {

        $photo = $this->getDoctrine()->getRepository("MyShopDefaultBundle:ProductPhoto")
            ->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($photo);
        $manager->flush();

        return $this->redirectToRoute("my_shop_admin.product_list");
    }

    public function sendMailAction($id)
    {
        $photo = $this->getDoctrine()->getManager()->getRepository("MyShopDefaultBundle:ProductPhoto")->find($id);

        $photoFile = $this->get("kernel")->getRootDir() . "/../web/photos/" . $photo->getFileName();
        $message = new \Swift_Message();
        $message->setTo("avonavis@gmail.com");
        $message->addFrom("avonavis@gmail.com");
        $message->setBody("welcome to our online-shop!", "text/html");
        $message->attach(\Swift_Attachment::fromPath($photoFile));
        $mailer = $this->get("mailer");

        $mailer->send($message);


        $idProduct = $photo->getProduct()->getId();


        return $this->redirectToRoute("my_shop_admin.product_photo_list", [
            'idProduct' => $idProduct,
            "photo" =>$photo
        ]);
    }



//        $htmlResult = $this->renderView("MyShopAdminBundle::email.html.twig", [
//            "name" => "Svetlana"
//        ]);

    //$message->setBody($htmlResult, "text/html");
}