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
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class ProductController extends Controller
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

            if ($form->isSubmitted()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($product);
                $manager->flush();

               $mailSender= $this->get("myshop_admin.mail_sender");

                $model= ['model'=>$product->getModel()];
                $format = "text/html";
                $mailSender->sendMail("avonavis@gmail.com", "igorphphillel@gmail.com",$model, $format);

                /*$message = new \Swift_Message();
                $message->setTo("avonavis@gmail.com");
                $message->addFrom("igorphphillel@gmail.com");
                $message->setBody(
                    $this->renderView(
                     'MyShopAdminBundle:Email:index.html.twig',
                        array('model' => $product->getModel())
                    ),
                    'text/html'
                );
                $mailer = $this->get("mailer");

                $mailer->send($message);*/


                $session= $this->get('session');
                 $session->set('notification', $this->get('session')->get('notification') . "product added. ");

                $this->addFlash("success",'Product added!');

                $logger=$this->get("logger");
                $logger->addInfo(json_encode([
                "product id"=> $product->getId(),
                "price"=> $product->getPrice()
]));

                return $this->redirectToRoute("my_shop_admin.product_list");
            }
        }


        return [
            "form" => $form->createView()
        ];
    }

    public function deleteAction($id)
    {
        $product = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Product")->find($id);
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($product);
        $manager->flush();

        $session= $this->get('session');
        $session->set('notification', $this->get('session')->get('notification') . "product removed. ");
        return $this->redirectToRoute("my_shop_admin.product_list");
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


                $session= $this->get('session');
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
    public function listAction()
    {
        $productList = $this->getDoctrine()
            ->getManager()
            ->createQuery("select p, c from MyShopDefaultBundle:Product p join p.category c")
            ->getResult();
$session= $this->get('session');
                 $session->set( 'history',  $this->get('session')->get('history').'product update ');
        return ["productList" => $productList];
    }

    /**
     * @Template()
     */
    public function CreateIconAction(Request $request, $idProduct)
    {
        $manager = $this->getDoctrine()->getManager();
        $product = $manager->getRepository("MyShopDefaultBundle:Product")->find($idProduct);

        if ($product == null) {
            return $this->createNotFoundException("Product not found!");
        }
        $photo = new IconPhoto();
        $form = $this->createForm(IconPhotoType::class,$photo);

        if ($request->isMethod("Post"))
        {
            $form->handleRequest($request);

            $filesArray= $request->files->get("myshop_defaultbundle_iconphoto");

            /** @var UploadedFile $photoFile */
            $photoFile = $filesArray["photoFile"];

            $imageCheckService=$this->get("myshop_admin.check_img");
            $imageCheckService->check($photoFile);
            $imageNameGenerate =$this->get("myshop_admin.name_generate");

            $photoFileName= $product->getId().  $imageNameGenerate->genName(). "." . $photoFile->getClientOriginalExtension();

            $photoDirPath= $this->get("kernel")->getRootDir(). "/../web/photos/";
            $photoFile->move($photoDirPath, $photoFileName);

            $photo->setFileName($photoFileName);
            $photo->setProduct($product);

            $manager->persist($photo);
            $manager->flush();

        }

        return[
            "product"=>$product,
            "form"=>$form->createView()
        ];

    }


}
