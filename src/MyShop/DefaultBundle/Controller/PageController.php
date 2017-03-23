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

class PageController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction($pageKey)
    {
        $page = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Page")->findOneBy(["pageKey" => $pageKey]);

        if ($page == null) {
            throw $this->createNotFoundException();
        }

        return ["page" => $page];
    }

}
