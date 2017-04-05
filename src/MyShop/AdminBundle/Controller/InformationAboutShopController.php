<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\AdminBundle\Entity\InformationAboutShop;
use MyShop\AdminBundle\Form\InformationAboutShopType;
use MyShop\DefaultBundle\Entity\Category;
use MyShop\DefaultBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class InformationAboutShopController extends Controller
{

    /**
     * @Template()
     */
    public function addAction(Request $request)
    {
        $info = new InformationAboutShop();
        $form = $this->createForm(InformationAboutShopType::class, $info);

        {
            $form->handleRequest($request);

            if ($form->isSubmitted())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($info);
                $manager->flush();

                return $this->redirectToRoute("myshop.product_list");
            }
        }


        return [
            "form" => $form->createView()
        ];
    }

    /**
     * @Template()
     */
    public function listAction()
    {
        $list = $this->getDoctrine()->getRepository("MyShopAdminBundle:InformationAboutShop")->findAll();

        return ["list" => $list];
    }


    /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $info = $this->getDoctrine()->getRepository("MyShopAdminBundle:InformationAboutShop")->find($id);

        $form = $this->createForm(InformationAboutShopType::class, $info);


        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($info);
                $manager->flush();

                return $this->redirectToRoute("my_shop_admin.index");
            }
        }


        return [
            "form" => $form->createView(),
            "info" => $info
        ];
    }
}

