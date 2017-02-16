<?php

namespace MyShop\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NewsPhoto
 *
 * @ORM\Table(name="news_photo")
 * @ORM\Entity(repositoryClass="MyShop\DefaultBundle\Repository\NewsPhotoRepository")
 */
class NewsPhoto
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
     * @var News
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefaultBundle\Entity\News", inversedBy="photos")
     * @ORM\JoinColumn(name="id_news", referencedColumnName="id", onDelete="CASCADE")
     */

    private $news;


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
     * @return NewsPhoto
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
     * @return NewsPhoto
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
     * Set news
     *
     * @param \MyShop\DefaultBundle\Entity\News $news
     *
     * @return NewsPhoto
     */
    public function setNews(\MyShop\DefaultBundle\Entity\News $news = null)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \MyShop\DefaultBundle\Entity\News
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set smallFileName
     *
     * @param string $smallFileName
     *
     * @return NewsPhoto
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
}
