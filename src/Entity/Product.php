<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="additives_n", type="integer")
     */
    private $additives_n;

    /**
     * @ORM\Column(name="ingredients_from_palm_oil", type="integer")
     */
    private $ingredients_from_palm_oil;

    /**
     * @ORM\Column(name="ingredients_that_may_be_from_palm_oil", type="integer")
     */
    private $ingredients_that_may_be_from_palm_oil;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Additives", cascade={"persist"})
     */
    private $additives;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brands")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Countries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ingredients")
     */
    private $ingredients;

    //Add a method to add ingredients into a product

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\NutritionalInformation", cascade={"persist"})
     */
    private $nutritional_information;


    public function __construct()
    {
      $this->created_datetime       = new \Datetime();
      $this->last_modified_datetime = new \Datetime();
      $this->additives              = new ArrayCollection();
      $this->ingredients            = new ArrayCollection();
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
     * @param string $additives_n
     */
    public function setAdditivesN($additives_n)
    {
      $this->additives_n = $additives_n;
    }

    /**
     * @return string
     */
    public function getAdditivesN()
    {
      return $this->additives_n;
    }

    //Add a method to calculate the number of additives

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

    //Add a method to calculate the count of product which contents palm oil

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

    //Add a method to calculate the count of product which can contents palm oil

    /**
     * @return Countries
     */
    public function getCountry()
    {
      return $this->country;
    }

    /**
     * @return Ingredients
     */
    public function getIngredients()
    {
      return $this->ingredients;
    }

    /**
     * @return NutritionalInformation
     */
    public function getNutritionalInformation()
    {
      return $this->nutritional_information;
    }
}
