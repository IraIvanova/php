<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 03.04.17
 * Time: 23:36
 */

namespace MyShop\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use MyShop\DefaultBundle\Entity\Manufacturer;
use MyShop\DefaultBundle\Form\ManufacturerType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Validator\ConstraintViolationList;

class ManufacturerController extends Controller
{

    /**
     * @Template()
     */
    public function addAction(Request $request)
    {
        $manufacturer = new Manufacturer();
        $form = $this->createForm(ManufacturerType::class, $manufacturer);


            if ($request->isMethod("POST")) {
                $form->handleRequest($request);

                if ($form->isSubmitted()) {
                /** @var ConstraintViolationList */
                $errorList = $this->get("validator")->validate($manufacturer);
                if ($errorList->count() > 0) {
                    foreach ($errorList as $error) {
                        $this->addFlash('error', $error->getMessage());
                    }
                    return $this->redirectToRoute("my_shop_admin.manufacturer_add");
                }



                    $filesAr = $request->files->get("myshop_defaultbundle_manufacturer");


                    /** @var UploadedFile $iconFile */

                    $iconFile = $filesAr["iconFileName"];


                    $iconFileName = $this->get("myshop_admin.image_uploader")->uploadIcon($iconFile);
                    $manufacturer->setIconFileName($iconFileName);


                    $manager = $this->getDoctrine()->getManager();
                    $manager->persist($manufacturer);
                    $manager->flush();

                    return $this->redirectToRoute("myshop_admin.manufacturer_list");
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
        $manufacturer= $this->getDoctrine()->getRepository("MyShopDefaultBundle:Manufacturer")->find($id);
        $form= $this->createForm(ManufacturerType::class, $manufacturer);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            if ($form->isSubmitted()) {
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($manufacturer);
                $manager->flush();

                return $this->redirectToRoute("myshop_admin.manufacturer_list");
            }
        }
        return [
            "form"=> $form->createView(),
            "manufacturer"=> $manufacturer
        ];
    }


    public function deleteAction($id)
    {
        $manufacturer=$this->getDoctrine()->getRepository("MyShopDefaultBundle:Manufacturer")->find($id);

        $manager= $this->getDoctrine()->getManager();
        $manager->remove($manufacturer);
        $manager->flush();

        return $this->redirectToRoute("myshop_admin.manufacturer_list");
    }


    /**
     * @Template()
     */
      public function listAction()
      {
          $categoryList = $this->getDoctrine()
              ->getManager()
              ->createQuery("select m from MyShopDefaultBundle:Manufacturer m ")
              ->getResult();
  
          return ["categoryList" => $categoryList];
      }



}