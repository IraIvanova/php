<?php
namespace MyShop\DefaultBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\MenuItem;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

//    public function mainMenu(FactoryInterface $factory, array $options)
//    {
//        $menu = $factory->createItem('root');
//
//        $menu->addChild('Home', array('route' => 'myshop.index_page'));
//
//        // access services from the container!
//        $em = $this->container->get('doctrine')->getManager();
//        // findMostRecent and Blog are just imaginary examples
//        $blog = $em->getRepository('MyShopDefaultBundle:Category')->findMostRecent();
//
//        $menu->addChild('Latest Blog Post', array(
//            'route' => 'blog_show',
//            'routeParameters' => array('id' => $blog->getId())
//        ));
//
//        // create another menu item
//        $menu->addChild('About Me', array('route' => 'about'));
//        // you can also add sub level's to your menu's as follows
//        $menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));
//
//        // ... add more children
//
//        return $menu;
//    }
//    public function mainMenu (FactoryInterface $factory, array $options) {
//        $menu = $factory->createItem('root');
//
//        $request = $this->container->get('request');
//
//        $menu
//            ->addChild('Homepage', array(
//                'route' => 'myshop.index_page',
//            ));
//
//        $blog = $menu->addChild('Product list', array(
//            'route' => 'myshop.index_page'
//        ));
//
//        $blog->addChild('ProductView',array(
//            'route' => 'blog_post_view',
//            'routeParameters' => array('id' => $request->get('id', 1)),
//            'display' => false
//        ));
//
//        return $menu;
//    }
//
//
//    }
}