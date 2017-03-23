<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefaultBundle\Entity\Page;
use MyShop\DefaultBundle\Form\PageType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    /**
     * @Template()
    */
    public function indexAction()
    {
     $pageList = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Page")->getAllPages(true);

     return [ "pageList"=> $pageList ];
    }

    /**
     * @Template()
     */
    public function addAction(Request $request)
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);

        if ($request->isMethod("POST")) {

            $form->handleRequest($request);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($page);
            $manager->flush();

            $this->addFlash("Success", "Page successfully added!");

            return $this->redirectToRoute("my_shop_admin.page_list");

        }

        return ["form"=> $form->createView()];
    }

    /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $page = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Page")->find($id);
        $form = $this->createForm(PageType::class, $page);

        if ($request->isMethod("POST")) {

            $form->handleRequest($request);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($page);
            $manager->flush();

            $this->addFlash("Success", "Page successfully added!");

            return $this->redirectToRoute("my_shop_admin.page_list");

        }

        return ["form"=> $form->createView(),
        "page" =>$page
        ];
    }

    public function deleteAction($id)
    {
        $page = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Page")->find($id);

        $manager= $this->getDoctrine()->getManager();
        $manager->remove($page);
        $manager->flush();

         return $this->redirectToRoute("my_shop_admin.page_list");
    }
}