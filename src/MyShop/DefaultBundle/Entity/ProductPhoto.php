<?php

namespace MyShop\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPhoto
 *
 * @ORM\Table(name="product_photo")
 * @ORM\Entity(repositoryClass="MyShop\DefaultBundle\Repository\ProductPhotoRepository")
 */
class ProductPhoto
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="fileName", type="string", length=255, unique=true)
     */
    private $fileName;

    /**
     * @var string
     *
     * @ORM\Column(name="small_file_name", type="string", length=255)
     */
    private $smallFileName;

    /**
     * @var string
     *
     * @ORM\Column(name="medium_file_name", type="string", length=255)
     */
    private $mediumFileName;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefaultBundle\Entity\Product", inversedBy="photos")
     * @ORM\JoinColumn(name="id_product", referencedColumnName="id", onDelete="CASCADE")
    */
    private $product;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return ProductPhoto
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return ProductPhoto
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set product
     *
     * @param \MyShop\DefaultBundle\Entity\Product $product
     *
     * @return ProductPhoto
     */
    public function setProduct(\MyShop\DefaultBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MyShop\DefaultBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set smallFileName
     *
     * @param string $smallFileName
     *
     * @return ProductPhoto
     */
    public function setSmallFileName($smallFileName)
    {
        $this->smallFileName = $smallFileName;

        return $this;
    }

    /**
     * Get smallFileName
     *
     * @return string
     */
    public function getSmallFileName()
    {
        return $this->smallFileName;
    }

    /**
     * Set mediumFileName
     *
     * @param string $mediumFileName
     *
     * @return ProductPhoto
     */
    public function setMediumFileName($mediumFileName)
    {
        $this->mediumFileName = $mediumFileName;

        return $this;
    }

    /**
     * Get mediumFileName
     *
     * @return string
     */
    public function getMediumFileName()
    {
        return $this->mediumFileName;
    }
}
