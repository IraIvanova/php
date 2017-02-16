<?php

namespace MyShop\AdminBundle\Controller;


use MyShop\DefaultBundle\Form\NewsCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MyShop\DefaultBundle\Entity\NewsCategory;


class NewsCategoryController extends Controller
{

    /**
     * @Template()
     */
    public function addNewsCategoryAction(Request $request)
    {
       $newsCategory = new NewsCategory();
       $form = $this->createForm(NewsCategoryType::class, $newsCategory);

       if($request->isMethod("POST"))
       {
           $form->handleRequest($request);
           if($form->isSubmitted())
           {
               $manager= $this->getDoctrine()->getManager();
               $manager->persist($newsCategory);
               $manager->flush();
               return $this->redirectToRoute("my_shop_admin.category_list");
           }
       }
       return [
           "form" => $form->createView()
       ];
    }

    /**
     * @Template()
     */
    public function editNewsCategoryAction(Request $request, $id)
    {
        $newsCategory= $this->getDoctrine()->getRepository("MyShopDefaultBundle:NewsCategory")->find($id);
        $form = $this->createForm(NewsCategoryType::class, $newsCategory);

        if($request->isMethod("POST"))
        {
            $form->handleRequest($request);
            if($form->isSubmitted())
            {
                $manager= $this->getDoctrine()->getManager();
                $manager->persist($newsCategory);
                $manager->flush();

                return $this->redirectToRoute("my_shop_admin.category_list");
            }
        }
        return [
            "form" => $form->createView(),
            "newsCategory"=> $newsCategory
        ];
    }

    /**
     * @Template()
     */
    public function deleteNewsCategoryAction($id)
    {
        $newsCategory= $this->getDoctrine()->getRepository("MyShopDefaultBundle:NewsCategory")->find($id);

        $manager = $this->getDoctrine()->getManager();
        $manager->remove($newsCategory);
        $manager->flush();

        return $this->redirectToRoute("my_shop_admin.category_list");
    }

    /**
     * @Template()
     */
    public function newsListAction()
    {
        $newsCategoryList = $this->getDoctrine()->getRepository("MyShopDefaultBundle:NewsCategory")->findAll();

        return ["newsCategoryList" => $newsCategoryList];
    }
}