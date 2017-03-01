<?php

namespace MyShop\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DefaultController extends Controller
{
    /**
     * @Template()
    */
    public function indexAction()
    {
        $viewData = " ";
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




 return ["newArr"=> $newArr];
}



}
