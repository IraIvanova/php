<?php

namespace MyShop\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrderProduct
 *
 * @ORM\Table(name="order_product")
 * @ORM\Entity(repositoryClass="MyShop\DefaultBundle\Repository\OrderProductRepository")
 */
class OrderProduct
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
     * @var int
     *
     * @ORM\Column(name="idProduct", type="integer")
     */
    private $idProduct;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var int
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var CustomerOrder
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefaultBundle\Entity\CustomerOrder", inversedBy="products")
     * @ORM\JoinColumn(name="id_order", referencedColumnName="id")
     */
    private $order;

    public function getTotalPrice()
    {
        $sum = $this->getPrice() * $this->getCount();
        return $sum;
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
     * @return CustomerOrder
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param CustomerOrder $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }

    /**
     * Set idProduct
     *
     * @param integer $idProduct
     *
     * @return OrderProduct
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get idProduct
     *
     * @return int
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return OrderProduct
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return OrderProduct
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set count
     *
     * @param integer $count
     *
     * @return OrderProduct
     */
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }
}

