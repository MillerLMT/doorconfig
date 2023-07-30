<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity
 */
class Color
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;


    /**
     * @ORM\Column(type="integer")
     */
    protected $price;


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

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
    public function getImages()
    {
        $images = [];
        $pathForImages = '../public/image/door/' . strtolower($this->getName());
        $imageNames = scandir($pathForImages);

        unset($imageNames[0]);
        unset($imageNames[1]);
        if ($imageNames) {
            foreach ($imageNames as $imageName) {
                $imagePath = '/image/door/' . $this->getName() . '/' . $imageName;
                $images[] = $imagePath;
            }
        }
        return $images;
    }

    public function getImage() {
        $images = $this->getImages();
        if ($images) {
            return $images[0];
        }
        return '';
    }


}