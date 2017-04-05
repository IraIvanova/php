<?php

namespace MyShop\DefaultBundle\Controller;

use GuzzleHttp\Client;
use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DefaultController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        $doctrine = $this->getDoctrine();
        $manager = $doctrine->getManager();
        $repository = $manager->getRepository("MyShopDefaultBundle:Product");
        //$productList= $this->getDoctrine()->getManager()->createQuery("select p from MyShopDefaultBundle:Product p limit 6 ")->getResult();

        $productList = $repository->findAll();


        return [
            "productList" => $productList

        ];

    }

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

        if ($product == null)
            throw new NotFoundHttpException();

        $photo = $product->getPhotos();


        return [
            "product" => $product,
            "photo" => $photo
        ];
    }

    /**
     * @Template()
     */
    public function showProductListAction($page = 1, $maxItemPerPage = 9)
    {
        $productList = $this->get("myshop_admin.product.storage")->getProductListPagination($page, $maxItemPerPage);

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

        $newsList = $manager->getRepository("MyShopDefaultBundle:News")->findAll();


        return [
            "newsList" => $newsList,

        ];
    }

    public function clientCurlAction($idProduct)
    {
        $client = $this->get("curl_client");
        $request = [
            'jsonrpc' => '2.0',
            'method' => 'productDetails',
            'params' => ['productId' => $idProduct],
            'id' => rand()
        ];
        $newRequest = json_encode($request);
        $response = $client->send($newRequest);

        return new Response($response);
    }
//     $client = new Client();
//     $response = $client->request("POST", "http://127.0.0.1:8000/api/jsonrpc");
//     var_dump($response);
//     die();
    public function listAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();


        $allCategories = $manager->createQuery("select cat from MyShopDefaultBundle:Category cat where cat.parentCategory is null")->getResult();

        return $this->render(
            'MyShopDefaultBundle:Default:list.html.twig',
            array("allCategories" => $allCategories)
        );
    }

    /**
     * @Template()
     */
    public function categoryAction()
    {
        $manager = $this->getDoctrine()->getManager();


        $allCategories = $manager->createQuery("select cat from MyShopDefaultBundle:Category cat where cat.parentCategory is null")->getResult();

        return ["allCategories" => $allCategories];
    }

    /**
     * @Template()
     */
    public function showProductListByCategoryAction($idCategory)
    {
        $category = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Category")->find($idCategory);
        $productList = $category->getProductList();


        return ["productList" => $productList];
    }


}