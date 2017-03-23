<?php

namespace MyShop\DefaultBundle\Convertor;

use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Entity\Page;

class ProductConvertor
{
    /**
    *@return Product
    */
    public function convertPageToProduct(Page $page)
    {
        $product = new Product();
        $product->setModel($page->getTitle());
        $product->setPrice(99999999);
        $product->setDescription($page->getContent);

        return $product;
    }
}