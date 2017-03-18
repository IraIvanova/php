<?php
namespace MyShop\AdminBundle\DTO;

class UploadedImageResult
{
private $smallFilename;

private $mediumFileName;

private $bigFileName;




public function __construct($smallFilename, $mediumFileName, $bigFileName)
{
    $this->smallFilename = $smallFilename;
    $this->mediumFileName = $mediumFileName;
    $this->bigFileName = $bigFileName;

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


}