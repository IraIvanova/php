<?php

namespace MyShop\DefaultBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;


/**
 * CustomerOrder
 *
 * @ORM\Table(name="customer_order")
 * @ORM\Entity(repositoryClass="MyShop\DefaultBundle\Repository\CustomerOrderRepository")
 */
class CustomerOrder
{
    const STATUS_OPEN = 1;
    const STATUS_DONE = 2;
    const STATUS_REJECT = 3;

    const DELIVERY_NOVAYA_POSHTA = 1;
    const DELIVERY_SELF = 2;
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=255, nullable=true)
     */
    private $phoneNumber;


    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefaultBundle\Entity\Customer", inversedBy="orders")
     * @ORM\JoinColumn(name="id_customer", referencedColumnName="id" )
     */
    private $customer;
    
        /**
     * @var int
     * 
     * @ORM\Column(name="delivery", type="integer")
     */
    private $delivery;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true )
     */
    private $adress;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MyShop\DefaultBundle\Entity\OrderProduct", mappedBy="order" , cascade= {"all"}))
     */
    private $products;

    /**
     * * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=true)
     */
    private $comment;

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }


    public function __construct()
    {
        $this->setDateCreated(new \DateTime("now"));
        $this->setStatus(self::STATUS_OPEN);
        $this->products = new ArrayCollection();
        $this->setDelivery(self::DELIVERY_NOVAYA_POSHTA);
  
    }

    /**
     * @return mixed
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * @param mixed $delivery
     */
    public function setDelivery($delivery)
    {
        $this->delivery = $delivery;
    }


    public function getTotalPrice()
    {
        $sum = 0;
        
        /**@var OrderProduct $product*/
        foreach ($this->products as $product)
        {
            $sum += $product->getPrice() * $product->getCount();
        }
        return $sum;
    }

    /**
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * @param string $adress
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;
    }
    public function getAllProductPrice()
    {
        $sum = 0;
        /**@var CustomerOrder $products*/
        foreach($this->products as $product){
            $sum += $product->getTotalPrice();
        }
        return $sum;
    }
    
    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts($products)
    {
        $this->products = $products;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
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
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return CustomerOrder
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return CustomerOrder
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return CustomerOrder
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    /**
     * Add product
     *
     * @param \MyShop\DefaultBundle\Entity\OrderProduct $product
     *
     * @return CustomerOrder
     */
    public function addProduct(\MyShop\DefaultBundle\Entity\OrderProduct $product)
    {
        $product->setOrder($this);
        $this->products[] = $product;
        return $this;
    }
    /**
     * Remove product
     *
     * @param \MyShop\DefaultBundle\Entity\OrderProduct $product
     */
    public function removeProduct(\MyShop\DefaultBundle\Entity\OrderProduct $product)
    {
        $this->products->removeElement($product);
    }


}
