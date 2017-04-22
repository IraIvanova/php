<?php
namespace MyShop\DefaultBundle\Controller;

use MyShop\DefaultBundle\Entity\CustomerOrder;
use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Entity\OrderProduct;
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

    /**
     * @Template()
     */
    public function orderProductAction(CustomerOrder $order)
    {
        $products = $order->getProducts();

        foreach ($products as $product)
        {
            $productShop = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Product")->find($product->getIdProduct());

            if($productShop == null){

                $product->setIdProduct(null);
            }
        }
        return ['order' => $order];
    }

    public function removeOrderProductAction(OrderProduct $orderProduct)
    {
        $manager= $this->getDoctrine()->getManager();
        $manager->remove($orderProduct);
        $manager->flush();

        return $this->redirectToRoute("myshop.basket");
    }
    
    
    /**
     * @Template()
     */
    public function historyOrderAction()
    {
        $customer= $this->getUser();
        $orders = $this->getDoctrine()->getRepository("MyShopDefaultBundle:CustomerOrder")->findBy(['customer'=>$customer]);
        
        return ['orders' => $orders];
    }




    public function addToBasketAction($idProduct)
    {
        $manager = $this->getDoctrine()->getManager();
        $customer = $this->getUser();
        $order = $manager->getRepository('MyShopDefaultBundle:CustomerOrder')->getOrCreateOrder($customer);

        $dql = 'select p from MyShopDefaultBundle:OrderProduct p where p.order = :orderCustomer and p.idProduct = :idProduct';
        /** @var OrderProduct $productOrder */
        $productOrder = $manager->createQuery($dql)->setParameters([
            'idProduct' => $idProduct,
            'orderCustomer' => $order
        ])->getOneOrNullResult();
       
           if ($productOrder !== null)
        {
            $count = $productOrder->getCount();
            $productOrder->setCount($count + 1);
            $manager->persist($productOrder);
            $manager->flush();
            return $this->redirectToRoute("myshop.index_page");
        }
        else {
            $productShop = $manager->getRepository("MyShopDefaultBundle:Product")->find($idProduct);
            $productOrder = new OrderProduct();
           $productOrder->setCount(1);
            $productOrder->setModel($productShop->getModel());
            $productOrder->setPrice($productShop->getPrice());
            $productOrder->setIdProduct($productShop->getId());
            $productOrder->setOrder($order);
            $manager->persist($productOrder);
            $manager->flush();
            
              

//            $message = new \Swift_Message();
//            $message->setTo("avonavis@gmail.com");
//            $message->addFrom("avonavis@gmail.com");
//            $message->setSubject('New order!');
//            $message->setBody();
//
//            $mailer = $this->get("mailer");
//
//            $mailer->send($message);

            $this->addFlash("success", "Product is added to cart!");
            return $this->redirectToRoute("myshop.index_page");
        }
    }



    /**
     * @Template()
     */
    public function confirmAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $customer = $this->getUser();
        $order = $manager->getRepository('MyShopDefaultBundle:CustomerOrder')->getOrCreateOrder($customer);
        $form = $this->createForm(CustomerOrderType::class, $order);
        if ($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            $order->setStatus(CustomerOrder::STATUS_DONE);
            $manager->persist($order);
            $manager->flush();
            
            
            $cont=$order->getCustomer();
              $mailSender= $this->get("myshop_admin.mail_sender");
              $mailSender->sendMail("avonavis@gmail.com", "avonavis@gmail.com",$cont);

            return $this->redirectToRoute("myshop.index_page");
        }
        return [
            'form' => $form->createView(),
            'order' => $order
        ];
    }


    public function recalculationCurrentPriceAction(Request $request)
    {
        $manager = $this->getDoctrine()->getManager();
        $customer = $this->getUser();
        $order = $manager->getRepository('MyShopDefaultBundle:CustomerOrder')->getOrCreateOrder($customer);
        $products = $order->getProducts();
        /** @var OrderProduct $product */
        foreach ($products as $product) {
            $key = "prod_" . $product->getId();
            $productCount = $request->get($key);
            $productCount = intval($productCount);
            if ($productCount < 0) {
                $product->setCount(1);
            } elseif ($productCount == 0) {
                $this->removeOrderProductAction($product);
            } else {
                $product->setCount($productCount);
            }
        }

        $manager->persist($order);
        $manager->flush();

        return $this->redirectToRoute("myshop.basket");
    }

}