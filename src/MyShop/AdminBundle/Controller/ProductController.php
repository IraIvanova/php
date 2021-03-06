<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefaultBundle\Entity\IconPhoto;

use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Form\IconPhotoType;
use MyShop\DefaultBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\ConstraintViolationList;

class ProductController extends BaseController
{

    /**
     * @Template()
     */
    public function addAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);


            //$result = $this->get("myshop_admin.image_uploader")->uploadImage($photoFile, $idProduct);

            if ($form->isSubmitted()) {

                /** @var ConstraintViolationList */
                $errorList = $this->get("validator")->validate($product);
                if ($errorList->count() > 0) {
                    foreach ($errorList as $error) {
                        $this->addFlash('error', $error->getMessage());
                    }
                    return $this->redirectToRoute("my_shop_admin.product_add");
                }
                $productId = $product->getId();

                $filesAr = $request->files->get("myshop_defaultbundle_product");
               

                /** @var UploadedFile $iconFile */

                $iconFile = $filesAr["iconFile"];

                $iconFileName = $this->get("myshop_admin.image_uploader")->uploadIcon($iconFile);


                $mainPhotoFile = $filesAr["mainPhotoFile"];
                $mainPhotoFileName = $this->get("myshop_admin.image_uploader")->uploadMainPhoto($mainPhotoFile);

                $product->setIconFileName($iconFileName);
                $product->setMainPhotoFileName($mainPhotoFileName);


                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();

                //  $mailSender= $this->get("myshop_admin.mail_sender");
                //  $mailSender->sendMail("avonavis@gmail.com", "igorphphillel@gmail.com","product added!");

                /*$message = new \Swift_Message();
                $message->setTo("avonavis@gmail.com");
                $message->addFrom("igorphphillel@gmail.com");
                $message->setSubject('Admin Panel')
                $message->setBody(
                    $this->renderView(
                     'MyShopAdminBundle:Email:index.html.twig',
                        array('model' => $product->getModel())
                    ),
                    'text/html'
                );
                $mailer = $this->get("mailer");

                $mailer->send($message);*/

//                $event = new ProductAddEvent($product);
//                $this->get("event_dispatcher")->dispatch("product_add_event", $event);

                $session = $this->get('session');
                $session->set('notification', $this->get('session')->get('notification') . "product added. ");

                $this->addFlash("success", 'Product added!');


                return $this->redirectToRoute("my_shop_admin.product_list");
            }
        }


        return [
            "form" => $form->createView()
        ];
    }

    public function deleteAction($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Product")->find($id);
        $photos = $product->getPhotos();
        $photoRemover = $this->get("myshop_admin.photo_remover");

        foreach ($photos as $photo) {
            $photoRemover->removePhoto($photo);
        }
        $manager->remove($product);
        $manager->flush();

//        $session = $this->get('session');
//        $session->set('notification', $this->get('session')->get('notification') . "product removed. ");
        return $this->redirectToRoute("my_shop_admin.product_list");
    }
    
    public function deleteAjaxAction($id)
    {
        $this->deleteAction($id);
        $responseJson = new JsonResponse(["message"=>"Product deleted!"]);
        return $responseJson;
    }


    /**
     * @Template()
     */

    public function editAction(Request $request, $id)
    {
        $product = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Product")->find($id);

        $form = $this->createForm(ProductType::class, $product);


        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();


                $session = $this->get('session');
                $session->set('notification', $this->get('session')->get('notification') . "product edit.");
                return $this->redirectToRoute("my_shop_admin.product_list");
            }
        }

        return [
            "form" => $form->createView(),
            "product" => $product
        ];
    }


    public function listByCategoryAction($id_category)
    {
        $category = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Category")->find($id_category);
        $productList = $category->getProductList();

        return $this->render("@MyShopAdmin/Product/list.html.twig", [
            "productList" => $productList
        ]);
    }


    /**
     * @Template()
     */

    public function listAction($page)
    {
        $query = $this->getDoctrine()
            ->getManager()
            ->createQuery("select p,c  from MyShopDefaultBundle:Product p join p.category c ");
        $paginator = $this->get('knp_paginator');

        $productList = $paginator->paginate(
            $query, /* query NOT result */
            $page/*page number*/,
            3/*limit per page*/
        );

        return ["productList" => $productList];
    }

    


}
