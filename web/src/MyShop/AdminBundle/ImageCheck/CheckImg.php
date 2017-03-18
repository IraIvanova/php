<?php

namespace MyShop\AdminBundle\ImageCheck;

use Symfony\Component\HttpFoundation\File\UploadedFile;


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

    public function __construct($imageTypeList)
    {
        $this->imageTypeList = $imageTypeList;
    }

    public function check($photoFile)
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

        $fileExt = $photoFile->getClientOriginalExtension();
        $checkTrue = false;
        foreach ($this->imageTypeList as $imgType) {
            if ($fileExt == $imgType[0]) {
                $checkTrue = true;
            }
        }

        if ($checkTrue == false) {
            throw new \InvalidArgumentException("Extension is blocked!");
        }

        return true;
    }
}


