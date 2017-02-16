<?php

namespace MyShop\DefaultBundle\Controller;

use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{


    public function createProductAction()
    {
        $product = new Product();
        $product->setModel("z520");
        $product->setPrice(1200);
        $product->setDescription("New Smartphone!");


        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();

        $manager->persist($product);
        $manager->flush();

        $response = new Response();
        $response->setContent($product->getId());
        return $response;
    }

    /**
     * @Template()
    */
    public function showProductAction(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();

        $repository = $manager->getRepository("MyShopDefaultBundle:Product");
        $product = $repository->find($id);

        $photo= $product->getPhotos();



        return [
            "product" => $product,
                "photo"=> $photo
        ];
    }

    /**
     * @Template()
    */
    public function showProductListAction()
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();

        $repository = $manager->getRepository("MyShopDefaultBundle:Product");

        $productList = $repository->findAll();


        return [
            "productList" => $productList

        ];
    }

    /**
     * @Template()
     */
    public function showNewsAction(Request $request, $id)
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();

        $repository = $manager->getRepository("MyShopDefaultBundle:News");
        $news = $repository->find($id);





        return [
            "news" => $news
        ];
    }

    /**
     * @Template()
     */
    public function showNewsListAction()
    {
        $manager = $this->getDoctrine()->getManager();

        $newsList= $manager->getRepository("MyShopDefaultBundle:News")->findAll();


        return [
            "newsList" => $newsList,

        ];
    }


}



