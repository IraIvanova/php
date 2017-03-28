<?php

namespace MyShop\AdminBundle\Event;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class MyExceptionListener
{

    public function onKernelException(GetResponseForExceptionEvent $event)
    {
//       $ex =$event->getException();
//
//        $data = [
//            'error'=>[
//                'code'=> $ex->getCode(),
//                'message' => $ex->getMessage()
//            ]
//        ];
//
//        $response = new Response();
//        $response->setContent(json_encode($data));
//        $event->setResponse($response);
    }
}