<?php

namespace MyShop\DefaultBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MyShop\AdminBundle\Entity\User;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        for ($i =0; $i<10; $i++)
        {
            $user = new User();
            $user->setEmail(rand(). "@mail.com");
            $user->setUsername(rand());
            $pass = rand(100000, 9999999);
            $passHash = $this->container->get("security.password_encoder")->encodePassword($user, $pass);
            $user->setPassword($passHash);

            $manager->persist($user);
            $manager->flush();
        }
    }
}