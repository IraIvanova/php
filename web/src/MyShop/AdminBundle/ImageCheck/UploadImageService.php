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



        /* $image= new ImageResize($photoDirPath . $photoFileName);
         $image->resizeToHeight(200);
         $smallFileName= "small_". $photoFileName;
         $image->save($photoDirPath. $smallFileName);

         $image2 = new ImageResize($photoDirPath . $photoFileName);
         $image2->resizeToHeight(400);
         $mediumFileName = "medium_" . $photoFileName;
         $image2->save($photoDirPath. $mediumFileName);*/

    $result = new UploadedImageResult($smallFileName,$photoFileName, $mediumFileName );

    return $result;

    }

    public function uploadIcon(UploadedFile $uploadedFile,  $iconFileName = null)
    {
        $imageNameGenerator = $this->generateName;
        $checkImg = $this->checkImg;
        if ($iconFileName == null) {
            $iconFileName = "icon_" . $imageNameGenerator->genName() . "." . $uploadedFile->getClientOriginalExtension();
        }
        $iconDirPath = $this->uploadImageRootDir . "../" . "photos/";
        try {
            $checkImg->check($uploadedFile);
        } catch (\InvalidArgumentException $ex) {
            die("Image type error!");
        }
        try {
            $uploadedFile->move($iconDirPath, $iconFileName);
        } catch (\Exception $exception) {
            echo "Can not move file!";
            throw $exception;
        }
        $img = new ImageResize($iconDirPath . $iconFileName);
        $img->resizeToBestFit(120, 120);
        $img->save($iconDirPath . $iconFileName);
        return $iconFileName;
    }
    public function uploadMainPhoto(UploadedFile $uploadedFile)
    {
        $imageNameGenerator = $this->generateName;
        $checkImg = $this->checkImg;

            $mainPhotoFileName  = "mainphoto_" . $imageNameGenerator->genName() . "." . $uploadedFile->getClientOriginalExtension();

        $photoDirPath = $this->uploadImageRootDir;
        try {
            $checkImg->check($uploadedFile);
        } catch (\InvalidArgumentException $ex) {
            die("Image type error!");
        }
        try {
            $uploadedFile->move($photoDirPath, $mainPhotoFileName );
        } catch (\Exception $exception) {
            echo "Can not move file!";
            throw $exception;
        }
        $img = new ImageResize($photoDirPath . $mainPhotoFileName );
        $img->resizeToBestFit(400, 400);
        $img->save($photoDirPath . $mainPhotoFileName );
        return $mainPhotoFileName ;
    }
}