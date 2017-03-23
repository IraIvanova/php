<?php

namespace MyShop\AdminBundle\Event;

use MyShop\DefaultBundle\Entity\Product;
use MyShop\Component\EventDispatcher\Event;

class ProductAddEvent extends Event
{
    /**
    *@var Product
    */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct()
    {
        return $this->product;
    }
}