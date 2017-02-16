<?php

namespace MyShop\AdminBundle\ImageCheck;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;

/*
 array(3) {
  [0]=>
  array(2) {
    [0]=>
    string(3) "jpg"
    [1]=>
    string(9) "image/jpg"
  }
  [1]=>
  array(2) {
    [0]=>
    string(3) "gif"
    [1]=>
    string(9) "image/gif"
  }
  [2]=>
  array(2) {
    [0]=>
    string(3) "png"
    [1]=>
    string(9) "image/png"
  }
}
 */
class CheckImg
{
    private $imageTypeList;

    public function __construct($typeList)
    {

       $this->imageTypeList = $typeList;
    }

    public function Check(UploadedFile $photoFile)
    {
        $checkTrue= false;
        $mimeType = $photoFile->getClientMimeType();
        foreach($this->imageTypeList as $imgType) {
            $checkTrue = false;
            if ($mimeType == $imgType[1]) {
                $checkTrue = true;
            }
        }
            if($checkTrue !== true)
            {
                throw new \InvalidArgumentException("MimeType is blocked!");
            }

        $fileExt = $photoFile->getClientOriginalExtension();
        $checkTrue= false;
        foreach($this->imageTypeList as $imgType) {
            if ($fileExt == $imgType[0]) {
                $checkTrue = true;
            }
        }
            if($checkTrue !== true)
            {
                throw new \InvalidArgumentExcepton("Extension is blocked!");
            }

        return true;
    }
}

