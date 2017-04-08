<?php

namespace MyShop\AdminBundle\Controller;

use GuzzleHttp\Client;
use MyShop\DefaultBundle\Entity\Comments;
use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Form\CommentsType;
use MyShop\DefaultBundle\Form\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentsController extends Controller
{
    /**
     * @Template()
     */
    public function addAction(Request $request)
    {
        $comments = new Comments();
        $form = $this->createForm(CommentsType::class, $comments);

        {
            $form->handleRequest($request);

            if ($form->isSubmitted())
            {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($comments);
                $manager->flush();

                return $this->redirectToRoute("myshop.index_page");
            }
        }


        return [
            "form" => $form->createView()
        ];
    }

    /**
     * @Template()
     */
    public function editAction(Request $request, $id)
    {
        $comments= $this->getDoctrine()->getRepository("MyShopDefaultBundle:Comments")->find($id);
        $form= $this->createForm(CommentsType::class, $comments);

        if($form->isSubmitted())
        {
            $manager= $this->getDoctrine()->getManager();
            $manager->persist($comments);
            $manager->flush();

            return $this->redirectToRoute("my_shop_admin.news_list");
        }
        return [
            "form"=> $form->createView(),
            "comments"=> $comments
        ];
    }

    public function deleteAction($id)
    {
        $comments=$this->getDoctrine()->getRepository("MyShopDefaultBundle:Comments")->find($id);

        $manager= $this->getDoctrine()->getManager();
        $manager->remove($comments);
        $manager->flush();

        return $this->redirectToRoute("my_shop_admin.news_list");
    }

    /**
     * @Template()
     */
    public function listAction()
    {

        $commentsList = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Comments")->findAll();

        return [
            "commentsList"=> $commentsList
        ];
    }

}
