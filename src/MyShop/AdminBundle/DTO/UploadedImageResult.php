<?php
namespace MyShop\AdminBundle\DTO;

class UploadedImageResult
{
private $smallFilename;

private $mediumFileName;

private $bigFileName;
private $mainPhotoFileName;


public function __construct($smallFilename, $mediumFileName, $bigFileName, $iconFileName, $mainPhotoFileName)
{
    $this->smallFilename = $smallFilename;
    $this->mediumFileName = $mediumFileName;
    $this->bigFileName = $bigFileName;
    $this->iconFileName = $iconFileName;
    $this->mainPhotoFileName = $mainPhotoFileName;

}

    /**
     * @return mixed
     */
    public function getMainPhotoFileName()
    {
        return $this->mainPhotoFileName;
    }

    /**
     * @return mixed
     */
    public function getBigFileName()
    {
        return $this->bigFileName;
    }

    /**
     * @return string
     */
    public function getSmallFilename()
    {
        return $this->smallFilename;
    }

    /**
     * @return string
     */
    public function getMediumFileName()
    {
        return $this->mediumFileName;
    }


    /**
     * @return mixed
     */
    public function getIconFileName()
    {
        return $this->iconFileName;
    }


}