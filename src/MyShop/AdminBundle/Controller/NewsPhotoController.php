<?php

namespace MyShop\AdminBundle\Controller;

use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use \Eventviva\ImageResize;
use MyShop\DefaultBundle\Entity\NewsPhoto;
use MyShop\DefaultBundle\Entity\News;
use MyShop\DefaultBundle\Form\NewsPhotoType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\Mapping as ORM;



class NewsPhotoController extends Controller
{

    /**
     * @Template()
     */
    public function addAction(Request $request, $idNews)
    {
        $manager = $this->getDoctrine()->getManager();
        $news = $manager->getRepository("MyShopDefaultBundle:News")->find($idNews);
        if ($news == null) {
            return $this->createNotFoundException("Product not found!");
        }

        $photo = new NewsPhoto();
        $form = $this->createForm(NewsPhotoType::class, $photo);

        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            $filesAr = $request->files->get("myshop_defaultbundle_newsphoto");

            /** @var UploadedFile $photoFile */
            $photoFile = $filesAr["photoFile"];
           /* $photoFile
            object(Symfony\Component\HttpFoundation\File\UploadedFile)#15 (7) {
  ["test":"Symfony\Component\HttpFoundation\File\UploadedFile":private]=>
  bool(false)
  ["originalName":"Symfony\Component\HttpFoundation\File\UploadedFile":private]=>
  string(14) "Lighthouse.jpg"
  ["mimeType":"Symfony\Component\HttpFoundation\File\UploadedFile":private]=>
  string(10) "image/jpeg"
  ["size":"Symfony\Component\HttpFoundation\File\UploadedFile":private]=>
  int(561276)
  ["error":"Symfony\Component\HttpFoundation\File\UploadedFile":private]=>
  int(0)
  ["pathName":"SplFileInfo":private]=>
  string(25) "C:\wamp64\tmp\php970F.tmp"
  ["fileName":"SplFileInfo":private]=>
  string(11) "php970F.tmp"
}
            */
            $checkImgService=$this->get("myshop_admin.check_img");
            $checkImgService->check($photoFile);

$imageNameGenerate =$this->get("myshop_admin.name_generate");

            $photoFileName = $news->getId() .$imageNameGenerate->genName(). "." . $photoFile->getClientOriginalExtension();
            $photoDirPath = $this->get("kernel")->getRootDir() . "/../web/photos/";

            $photoFile->move($photoDirPath, $photoFileName);


            $img = new ImageResize($photoDirPath . $photoFileName);
            $img->resizeToHeight(200);
            $smallPhotoName = "small_" . $photoFileName;
            $img->save($photoDirPath . $smallPhotoName);

            $photo->setSmallFileName($smallPhotoName);
            $photo->setFileName($photoFileName);
            $photo->setNews($news);

            $manager->persist($photo);

            $manager->flush();
        }

        return [
            "form" => $form->createView(),
            "news" => $news
        ];
    }

    /**
     * @Template()
     */
    public function listAction($idNews)
    {
        $news = $this->getDoctrine()->getRepository("MyShopDefaultBundle:News")->find($idNews);

        return [
            "news" => $news
        ];
    }

    /**
     * @Template()
     */
    public function editAction(Request $request,$idNews)
    {
        $photo= $this->getDoctrine()->getRepository("MyShopDefaultBundle:NewsPhoto")
            ->find($idNews);

        $form = $this->createForm(NewsPhotoType::class, $photo);
        if ($request->isMethod("POST")) {
            $form->handleRequest($request);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($photo);
            $manager->flush();

            return $this->redirectToRoute("my_shop_admin.product_list");
        }
        return [
            "form" => $form->createView(),
            "photo" => $photo
        ];
    }


    public function deleteAction($id)
    {

        $photo= $this->getDoctrine()->getRepository("MyShopDefaultBundle:NewsPhoto")
->find($id);

        $manager = $this->getDoctrine()->getManager();
             $manager->remove($photo);
             $manager->flush();

        return $this->redirectToRoute("my_shop_admin.news_list");
    }



}