<?php

namespace MyShop\AdminBundle\ImageCheck;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class BaseCheck
{ 
    protected $supportImageTypeList;

    public function __constructor($supportImageTypeList)
    {
        $this->supportImageTypeList = $supportImageTypeList; 
    }
    
    public function checkMimeType(UploadedFile $photoFile)
    {
        $checkTrue = false;
        $mimeType = $photoFile->getClientMimeType();
        var_dump( $this->supportImageTypeList  );
            die();
        foreach ($this->supportImageTypeList as $imgType) {
            
               if ($mimeType == $imgType[1]) {
                $checkTrue = true;
            }
        }
        if ($checkTrue !== true) {
            throw new \InvalidArgumentException("Mime type is blocked!");
        }
    }
}