<?php

namespace MyShop\DefaultBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * NewsCategory
 *
 * @ORM\Table(name="news_category")
 * @ORM\Entity(repositoryClass="MyShop\DefaultBundle\Repository\NewsCategoryRepository")
 */
class NewsCategory
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MyShop\DefaultBundle\Entity\News", mappedBy="newsCategory")
     */
    private $newsList;

    public function __construct()
    {
        $this->newsList = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return NewsCategory
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add newsList
     *
     * @param \MyShop\DefaultBundle\Entity\News $newsList
     *
     * @return NewsCategory
     */
    public function addNewsList(\MyShop\DefaultBundle\Entity\News $newsList)
    {
        $this->newsList[] = $newsList;

        return $this;
    }

    /**
     * Remove newsList
     *
     * @param \MyShop\DefaultBundle\Entity\News $newsList
     */
    public function removeNewsList(\MyShop\DefaultBundle\Entity\News $newsList)
    {
        $this->newsList->removeElement($newsList);
    }

    /**
     * Get newsList
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNewsList()
    {
        return $this->newsList;
    }
}
