<?php


namespace MyShop\AdminBundle\ImageCheck;


class GenerateName
{
    public function genName()
    {
        return rand(1000000, 9999999) ;
    }
}