<?php

namespace MyShop\AdminBundle\ImageCheck;

use Eventviva\ImageResize;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;


class ResizeImage
{
    private $imageSizeList;

    public function __construct($imageSizeList)
    {
        $this->imageSizeList = $imageSizeList;

    }

    public function uploadSmallImg($photoDirPath, $photoFileName)
    {
        $image= new ImageResize($photoDirPath . $photoFileName);
        $height= $this->imageSizeList[1][1];
        $image->resizeToHeight($height);
        $smallFileName= "small_". $photoFileName;
        $image->save($photoDirPath. $smallFileName);
        return $smallFileName;

    }
    public  function uploadMediumImg($photoDirPath, $photoFileName)
    {
        $image2 = new ImageResize($photoDirPath . $photoFileName);
        $height= $this->imageSizeList[0][1];
        $image2->resizeToHeight($height);
        $mediumFileName = "medium_" . $photoFileName;
        $image2->save($photoDirPath. $mediumFileName);

        return $mediumFileName;
    }
    
    public  function uploadManufacturerImg($photoDirPath, $photoFileName)
    {
        $image = new ImageResize($photoDirPath . $photoFileName);
        $height= $this->imageSizeList[3][1];
        $width = $this->imageSizeList[3][0];
        $image->resizeToBestFit($height, $width);
        $manufacturerFileName = "manufacturer_" . $photoFileName;
        $image->save($photoDirPath. $manufacturerFileName);

        return $manufacturerFileName;
    }



}