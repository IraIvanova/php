<?php

namespace MyShop\AdminBundle\ImageCheck;


use Eventviva\ImageResize;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use MyShop\AdminBundle\DTO\UploadedImageResult;

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

    /**
     * @var ResizeImage
     */
    private $imageSizeList;


    public function __construct(CheckImg $checkImg, GenerateName $generateName, ResizeImage $imageSizeList )
    {
        $this->checkImg= $checkImg;
        $this->generateName = $generateName;
        $this->imageSizeList = $imageSizeList;
    }

    public function setUploadImageRootDir($uploadImageRootDir)
    {
        $this->uploadImageRootDir = $uploadImageRootDir;
    }

    /**
     * @return UploadedImageResult
     */
    public function uploadImage(UploadedFile $uploadedFile, $productId)
    {

        $nameGenService = $this->generateName;
        $photoFileName = $productId . $nameGenService->genName() . "." . $uploadedFile->getClientOriginalExtension();

        $photoDirPath = $this->uploadImageRootDir;

        $uploadedFile->move($photoDirPath, $photoFileName);

        $smallFileName =$this->imageSizeList->uploadSmallImg($photoDirPath, $photoFileName);

        $mediumFileName = $this->imageSizeList->uploadMediumImg($photoDirPath, $photoFileName);
        $iconFileName = $this->imageSizeList->uploadIconImg($photoDirPath, $photoFileName);

        $mainPhotoFileName = $this->imageSizeList->uploadMainPhoto($photoDirPath, $photoFileName);


        /* $image= new ImageResize($photoDirPath . $photoFileName);
         $image->resizeToHeight(200);
         $smallFileName= "small_". $photoFileName;
         $image->save($photoDirPath. $smallFileName);

         $image2 = new ImageResize($photoDirPath . $photoFileName);
         $image2->resizeToHeight(400);
         $mediumFileName = "medium_" . $photoFileName;
         $image2->save($photoDirPath. $mediumFileName);*/

    $result = new UploadedImageResult($smallFileName,$photoFileName, $mediumFileName, $iconFileName, $mainPhotoFileName );

    return $result;

    }
}