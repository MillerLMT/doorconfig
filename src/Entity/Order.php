<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 * @ORM\Table("Orders")
 */
class Order
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * @ORM\ManyToOne(targetEntity="Color")
     * @ORM\JoinColumn(name="colorId",referencedColumnName="id")
     */
    protected $color;

    /**
     * @ORM\ManyToOne(targetEntity="DoorHeight")
     * @ORM\JoinColumn(name="doorHeightId",referencedColumnName="id")
     */
    protected $doorHeight;

    /**
     * @ORM\ManyToOne(targetEntity="DoorWidth")
     * @ORM\JoinColumn(name="doorWidthId",referencedColumnName="id")
     */
    protected $doorWidth;

    /**
     * @ORM\ManyToOne(targetEntity="FilmColor")
     * @ORM\JoinColumn(name="filmColorId",referencedColumnName="id")
     */
    protected $filmColor;

    /**
     * @ORM\ManyToOne(targetEntity="HandleColor")
     * @ORM\JoinColumn(name="handleColorId",referencedColumnName="id")
     */
    protected $handleColor;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $price;

    /**
     * @ORM\Column(type="decimal")
     */
    protected $dealerPrice;

    public function getId()
    {
        return $this->id;
    }

    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getColor()
    {
        return $this->color;
    }

    public function setColor(Color $color)
    {
        $this->color = $color;

        return $this;
    }

    public function getDoorHeight()
    {
        return $this->doorHeight;
    }

    public function setDoorHeight(DoorHeight $doorHeight)
    {
        $this->doorHeight = $doorHeight;

        return $this;
    }

    public function getDoorWidth()
    {
        return $this->doorWidth;
    }

    public function setDoorWidth(DoorWidth $doorWidth)
    {
        $this->doorWidth = $doorWidth;

        return $this;
    }

    public function getFilmColor()
    {
        return $this->filmColor;
    }

    public function setFilmColor(FilmColor $filmColor)
    {
        $this->filmColor = $filmColor;

        return $this;
    }

    public function getHandleColor()
    {
        return $this->handleColor;
    }

    public function setHandleColor(HandleColor $handleColor)
    {
        $this->handleColor = $handleColor;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    public function getDealerPrice()
    {
        return $this->dealerPrice;
    }

    public function setDealerPrice($dealerPrice)
    {
        $this->dealerPrice = $dealerPrice;

        return $this;
    }
}