<?php

namespace MyShop\AdminBundle\Twig;



class Extension extends \Twig_Extension
{
    public function getFilters()
    {
        return 
        [  new \Twig_SimpleFilter("greetings", [$this, "showGreetings"])];
    }

    public function showGreetings($data)
    {
        $result= "Welcome, dear friend ". $data ;
        return $result;
            }

     public function getName()
     {
         return "greeting_extension";
     }       
}
