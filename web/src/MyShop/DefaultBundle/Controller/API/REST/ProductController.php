<?php

namespace MyShop\DefaultBundle\Controller\API\REST;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use MyShop\DefaultBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
 public function productDetailsAction($id)
 {
     /** @var Product $product */
     $product = $this->getDoctrine()->getRepository('MyShopDefaultBundle:Product')->find($id);

     $productArray = [
       'model' => $product->getModel(),
         'price' => $product->getPrice(),
         'description' => $product->getDescription(),
         'date' => $product->getDateCreatedAt()->format('d.m.Y')
     ];

     $response = new JsonResponse($productArray);
     return $response;
 }

 public function productDetailsXMLAction(Request $request, $id)
 {
     /** @var Product $product */
     $product = $this->getDoctrine()->getRepository('MyShopDefaultBundle:Product')->find($id);

     $xml = new \SimpleXMLElement('<product></product>');
     $xml->addAttribute("id", $product->getId());
     $xml->addChild('model', $product->getModel());
     $xml->addChild('price', $product->getPrice());
     $xml->addChild('description', $product->getDescription());
     $xml->addChild('date', $product->getDateCreatedAt()->format('d.m.Y'));

     $xmlStr= $xml->asXML();

     $response = new Response($xmlStr);
     return $response;
 }

}