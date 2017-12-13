<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandsRepository")
 */
class Brands
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="brand", type="string", length=20)
     */
    private $brand;

    /**
     * @ORM\Column(name="brand_tags", type="string", length=20)
     */
    private $brand_tags;

    /**
     * @return string
     */
    public function getBrand()
    {
      return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand($brand)
    {
      $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getBrandTags()
    {
      return $this->brand_tags;
    }

    /**
     * @param string $brand_tags
     */
    public function setBrandTags($brand_tags)
    {
      $this->brand_tags = $brand_tags;
    }
}

