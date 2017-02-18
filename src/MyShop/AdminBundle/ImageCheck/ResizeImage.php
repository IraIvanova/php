<?php

namespace MyShop\AdminBundle\ImageCheck;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;


class ResizeImage
{
    private $imageSizeList;

    public function __construct($imageSizeList)
    {
        $this->imageSizeList = $imageSizeList;
    }

}

