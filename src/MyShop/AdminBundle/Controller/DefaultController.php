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
        $viewData = [];
        $session = $this->get('session')->get('history');
var_dump($session);
die();
        if ($session->has('history')) {
            $viewData['history'] = $session->get('history');






        }
 return ["new_array" =>$new_array];
}



}
