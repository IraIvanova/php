<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 10.04.17
 * Time: 18:36
 */

namespace MyShop\DefaultBundle\Controller;


use Elasticsearch\Endpoints\Indices\Upgrade\Post;
use MyShop\DefaultBundle\Entity\Customer;
use MyShop\DefaultBundle\Form\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CustomerController extends Controller
{
    /**
     * @Template()
     */
    public function loginAction()
    {
        return [];
    }


    /**
     * @Template()
     */
    public function registrationAction(Request $request)
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);

        if ($request->isMethod("POST")){
            $form->handleRequest($request);

            if ($form->isSubmitted())
            {

                $passHash = $this->get('security.password_encoder')->encodePassword($customer, $customer->getPlainPassword());
                $customer->setPassword($passHash);

                $manager= $this->getDoctrine()->getManager();
                $manager->persist($customer);
                $manager->flush();

                return $this->redirectToRoute("myshop.index_page");
            }
        }
        return ["form"=>$form->createView()];
    }
}