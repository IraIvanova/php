<?php

namespace MyShop\AdminBundle\Event;

class ProductSubscriber
{
    public function onProductAddEvent($event)
    {

var_dump($event);
die();
    }
}