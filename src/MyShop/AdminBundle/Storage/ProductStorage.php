<?php
/**
 * Created by PhpStorm.
 * User: irina
 * Date: 28.03.17
 * Time: 22:57
 */

namespace MyShop\AdminBundle\Storage;


use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

class ProductStorage
{

    /*
     * @var EntityManagerInterface
     */
    private $manager;

    /*
     * @var PaginationInterface
     */
    private $pagination;

    public function __construct(EntityManagerInterface $manager ,PaginationInterface $pagination   )
    {
        $this->manager = $manager;
        $this->pagination = $pagination;

    }

    public function getProductListPagination($page, $countPerPage=5)
    {
        $dql ="select p,c  from MyShopDefaultBundle:Product p join p.category c ";
        $query = $this->manager->createQuery($dql);

       $result= $this->pagination->paginate($query, $page, $countPerPage);

        return $result;
    }
}