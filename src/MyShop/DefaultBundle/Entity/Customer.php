<?php

namespace MyShop\DefaultBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="MyShop\DefaultBundle\Repository\CustomerRepository")
 */
class Customer implements UserInterface, \Serializable
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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    private $plainPassword;
    
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="MyShop\DefaultBundle\Entity\CustomerOrder", mappedBy="customer", cascade={"all"})
     */
    
    private $orders;

    /**
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * @param ArrayCollection $orders
     */
    public function setOrders($orders)
    {
        $this->orders = $orders;
    }

    /**
     * @param mixed $plainPassword
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;
    }


    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->setDateCreated(new \DateTime("now"));

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
     * Set email
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Customer
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }


    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Customer
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

    public function serialize()
    {
        $data = serialize([
            $this->getId(),
            $this->getUsername(),
            $this->getPassword()
        ]);
        
        return $data;
    }

    public function getRoles()
    {
        return ['ROLE_CUSTOMER'];
    }

    public function getSalt()
    {
        return "";
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function unserialize($serialized)
    {
         list($this->id, $this->email, $this->password) = unserialize($serialized);
    }

    /**
     * Add order
     *
     * @param \MyShop\DefaultBundle\Entity\CustomerOrder $order
     *
     * @return Customer
     */
    public function addOrder(\MyShop\DefaultBundle\Entity\CustomerOrder $order)
    {
        $order->setCustomer($this);
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \MyShop\DefaultBundle\Entity\CustomerOrder $order
     */
    public function removeOrder(\MyShop\DefaultBundle\Entity\CustomerOrder $order)
    {
        $this->orders->removeElement($order);
    }


    public function __toString()
    {
        return $this->email;
    }


}
