<?php

namespace MyShop\AdminBundle\ImageCheck;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadImageService
{
  /**
  * @var CheckImg
  */
    private $checkImg;

    /*
     * @var GenerateName
     */
    private $generateName;
    private $uploadImageRootDir;

    public function setUploadImageRootDir($uploadImageRootDir)
    {
        $this->uploadImageRootDir = $uploadImageRootDir;
    }

    public function __construct(CheckImg $checkImg, GenerateName $generateName )
    {
        $this->checkImg= $checkImg;
        $this->generateName = $generateName;
    }
    public function uploadImage(UploadedFile $uploadedFile)
    {

    }
}