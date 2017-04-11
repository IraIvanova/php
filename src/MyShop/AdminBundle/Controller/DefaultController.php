<?php

namespace MyShop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    public function uploadImageAction(Request $request)
    {
        /**@var UploadedFile $file */
        $file = $request->files->get("upload");

        $dir= $this->get("kernel")->getRootDir()."/../web/photos/";
        $file->move($dir, $file->getClientOriginalName());

        return new Response("/photos/". $file->getClientOriginalName());
    }

 
   public function loadUserAction()
{
    $this->get("load_predata")->loadUsers();
    $this->addFlash("success", "Demo user is added!");

    return $this->redirectToRoute("my_shop_admin.index");
}

    public function loadProductAction()
    {
        $this->get("load_predata")->loadProduct();
        $this->addFlash("success", "Demo product is added!");

        return $this->redirectToRoute("my_shop_admin.index");
    }

    public function loadCategoryAction()
    {
        $this->get("load_predata")->loadCategory();
        $this->addFlash("success", "Demo category is added!");

        return $this->redirectToRoute("my_shop_admin.index");
    }
    /**
     * @Template()
    */
    public function indexAction()
    {
     /*   $viewData = " ";
        $session = $this->get('session');
        if ($session->has("notification"))
        {
            $viewData= $session->get('notification');
        }

        $new=explode(".", $viewData);
        $newArr = array_slice($new, -5, 5);
        $string = implode(" | ", $newArr);



        $message = new \Swift_Message();
        $message->setTo("avonavis@gmail.com");
        $message->addFrom("igorphphillel@gmail.com");
        $message->setBody(
            $this->renderView(
                'MyShopAdminBundle:Email:index.html.twig',
                array('model' => $string)
            ),
            'text/html'
        );
        $mailer = $this->get("mailer");

        $mailer->send($message);




 return ["newArr"=> $newArr];*/
}
    public function testAction(Request $request)
    {
        if($request->isXmlHttpRequest()) {
            $response = new JsonResponse([
                "name" => 'Ira',
                "time" => time()
            ]);

            return $response;
        }
        return new Response("you are not Ajax!");
        
    }

}
