<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="url", type="string", length=120)
     */
    private $url;

    /**
     * @ORM\Column(name="created_datetime", type="datetime")
     */
    private $created_datetime;

    /**
     * @ORM\Column(name="last_modified_datetime", type="datetime")
     */
    private $last_modified_datetime;

    /**
     * @ORM\Column(name="product_name", type="string", length=120)
     */
    private $product_name;

    /**
     * @ORM\Column(name="serving_size", type="string", length=50)
     */
    private $serving_size;

    /**
     * @ORM\Column(name="ingredients_from_palm_oil", type="integer")
     */
    private $ingredients_from_palm_oil;

    /**
     * @ORM\Column(name="ingredients_that_may_be_from_palm_oil", type="integer")
     */
    private $ingredients_that_may_be_from_palm_oil;

    public function __construct()
    {
      $this->created_datetime = new \Datetime();
      $this->last_modified_datetime = new \Datetime();
    }

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
      $this->url = $url;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
      return $this->url;
    }

    /**
     * @param \Datetime $created_datetime
     */
    public function setCreatedDatetime($created_datetime)
    {
      $this->created_datetime = $created_datetime;
    }

    /**
     * @return \Datetime
     */
    public function getCreatedDatetime()
    {
      return $this->last_modified_datetime;
    }

    /**
     * @param \Datetime $last_modified_datetime
     */
    public function setLastModifiedDatetime(\Datetime $last_modified_datetime)
    {
      $this->last_modified_datetime = $last_modified_datetime;
    }

    /**
     * @return \Datetime
     */
    public function getLastModifiedDatetime()
    {
      return $this->last_modified_datetime;
    }

    /**
     * @param string $product_name
     */
    public function setProductName($product_name)
    {
      $this->product_name = $product_name;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
      return $this->product_name;
    }

    /**
     * @param string $serving_size
     */
    public function setServingSize($serving_size)
    {
      $this->serving_size = $serving_size;
    }

    /**
     * @return string
     */
    public function getServingSize()
    {
      return $this->serving_size;
    }

    /**
     * @param integer $ingredients_from_palm_oil
     */
    public function setIngredientsFromPalmOil($ingredients_from_palm_oil)
    {
      $this->ingredients_from_palm_oil = $ingredients_from_palm_oil;
    }

    /**
     * @return integer
     */
    public function getIngredientsFromPalmOil()
    {
      return $this->ingredients_from_palm_oil;
    }

    /**
     * @param integer $ingredients_that_may_be_from_palm_oil
     */
    public function setIngredientsThatMayBeFromPalmOil($ingredients_that_may_be_from_palm_oil)
    {
      $this->ingredients_that_may_be_from_palm_oil = $ingredients_that_may_be_from_palm_oil;
    }

    /**
     * @return integer
     */
    public function getIngredientsThatMayBeFromPalmOil()
    {
      return $this->ingredients_that_may_be_from_palm_oil;
    }
}
