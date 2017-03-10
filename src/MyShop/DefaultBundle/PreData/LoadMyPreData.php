<?php

namespace MyShop\DefaultBundle\PreData;

use Doctrine\ORM\EntityManager;
use Eventviva\ImageResize;
use MyShop\AdminBundle\Entity\User;
use MyShop\DefaultBundle\Entity\Category;
use MyShop\DefaultBundle\Entity\Product;

class LoadMyPreData
{
/**
 * @var EntityManager
 */
    private $manager;
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function loadUsers()
    {
        $user = new User();
        $user->setEmail("user2@gmail.com");
        $user->setUsername("2asdasd");
        $user->setPassword("2asdasd");

        $this->manager->persist($user);
        $this->manager->flush();

    }



    public function loadProduct()
    {

        $product = new Product();
        $product->setModel("z5");
        $product->setPrice(4000);
        $product->setDateCreatedAt(new \DateTime("now"));
        $product->setDescription("product description");
        $product->setIconFileName("6846090.jpg");
        $product->setMainPhotoFileName("6846090.jpg");


        $this->manager->persist($product);
        $this->manager->flush();
    }

    public function loadCategory()
    {
        $category = new Category();
        $category->setName("Smartphone");
        $category->setParentCategory(40);
        
        $this->manager->persist($category);
        $this->manager->flush();
    }
}