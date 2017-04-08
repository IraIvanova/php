<?php

namespace MyShop\AdminBundle\Twig;



class Extension extends \Twig_Extension
{
    public function getFilters()
    {
        return 
        [  new \Twig_SimpleFilter("currency", [$this, "showCurrency"])];
    }

    public function showCurrency($data)
    {
        $result= $data . "$" ;
        return $result;
            }

     public function getName()
     {
         return "currency_extension";
     }

    
    
}
