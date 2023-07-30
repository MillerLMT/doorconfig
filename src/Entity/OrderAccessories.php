<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 */
class OrderAccessories
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Order", cascade={"persist"})
     * @ORM\JoinColumn(name="orderId",referencedColumnName="id")
     */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="DoorAccessories")
     * @ORM\JoinColumn(name="doorAccessoriesId",referencedColumnName="id")
     */
    protected $doorAccessories;

    public function getId()
    {
        return $this->id;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setOrder(Order $order)
    {
        $this->order = $order;

        return $this;
    }

    public function getDoorAccessories()
    {
        return $this->doorAccessories;
    }

    public function setDoorAccessories(DoorAccessories $doorAccessories)
    {
        $this->doorAccessories = $doorAccessories;

        return $this;
    }
}