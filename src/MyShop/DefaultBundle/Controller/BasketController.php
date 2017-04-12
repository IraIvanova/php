<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 10.04.17
 * Time: 20:36
 */

namespace MyShop\DefaultBundle\Controller;



use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Entity\OrderProduct;
use MyShop\DefaultBundle\Form\CommentsType;
use MyShop\DefaultBundle\Form\CustomerOrderType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class BasketController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        $manager = $this->getDoctrine()->getManager();
        $customer = $this->getUser();
        $order = $manager->getRepository('MyShopDefaultBundle:CustomerOrder')->getOrCreateOrder($customer);
        return ['order' => $order];
    }





    public function addToBasketAction($idProduct)
    {
        $manager = $this->getDoctrine()->getManager();

        $customer = $this->getUser();
        $order = $manager->getRepository('MyShopDefaultBundle:CustomerOrder')->getOrCreateOrder($customer);

        $dql = 'select p from MyShopDefaultBundle:OrderProduct p where p.order= :orderFromCustomer and p.idProduct = :idProduct';

        /**@var OrderProduct $productOrder*/
        $productOrder = $manager->createQuery($dql)->setParameters([
            'orderFromCustomer' => $order,
            'idProduct' => $idProduct
        ])->getOneOrNullResult();
        if ($productOrder !== null) {

            $count = $productOrder->getCount();
            $productOrder->setCount($count + 1);
            $manager->persist($productOrder);
            $manager->flush();

            return $this->redirectToRoute('myshop.index_page');

        }
        else{

            $product = $manager->getRepository('MyShopDefaultBundle:Product')->find($idProduct);

            $productOrder = new OrderProduct();
            $productOrder->setCount(1);
            $productOrder->setIdProduct($product->getId());
            $productOrder->setModel($product->getModel());
            $productOrder->setPrice($product->getPrice());

            $manager->persist($productOrder);
            $manager->flush();

            return $this->redirectToRoute('myshop.index_page');

        }


    }

}