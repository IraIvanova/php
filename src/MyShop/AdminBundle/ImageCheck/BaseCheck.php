<?php

namespace MyShop\AdminBundle\ImageCheck;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class BaseCheck
{ 
    protected $imageTypeList;

    public function __constructor($imageTypeList)
    {
        $this->imageTypeList = $imageTypeList; 
    }
    
    public function checkMimeType(UploadedFile $photoFile)
    {
        $checkTrue = false;
        $mimeType = $photoFile->getClientMimeType();
        foreach ($this->imageTypeList as $imgType) {
            if ($mimeType == $imgType[1]) {
                $checkTrue = true;
            }
        }
        if ($checkTrue !== true) {
            throw new \InvalidArgumentException("Mime type is blocked!");
        }
    }
}