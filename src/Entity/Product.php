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
     * @ORM\Column(name="url", type="string", length=255)
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
     * @ORM\Column(name="product_name", type="string", length=120, nullable=true)
     */
    private $product_name;

    /**
     * @ORM\Column(name="serving_size", type="string", length=128)
     */
    private $serving_size;

    /**
     * @ORM\Column(name="additives_n", type="string", length=132)
     */
    private $additives_n;

    /**
     * @ORM\Column(name="ingredients_from_palm_oil_n", type="integer", nullable=true)
     */
    //private $ingredients_from_palm_oil_n;

    /**
     * @ORM\Column(name="ingredients_that_may_be_from_palm_oil_n", type="integer", nullable=true)
     */
    //private $ingredients_that_may_be_from_palm_oil_n;

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
    public function setProductName($product_name = null)
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
    public function setServingSize($serving_size = null)
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
    public function setAdditivesN($additives_n = null)
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
     * @param integer $ingredients_from_palm_oil_n
     */
    public function setIngredientsFromPalmOilN($ingredients_from_palm_oil_n)
    {
      $this->ingredients_from_palm_oil_n = $ingredients_from_palm_oil_n;
    }

    /**
     * @return integer
     */
    public function getIngredientsFromPalmOilN()
    {
      return $this->ingredients_from_palm_oil_n;
    }

    //Add a method to calculate the count of product which contents palm oil

    /**
     * @param integer $ingredients_that_may_be_from_palm_oil_n
     */
    public function setIngredientsThatMayBeFromPalmOilN($ingredients_that_may_be_from_palm_oil_n)
    {
      $this->ingredients_that_may_be_from_palm_oil_n = $ingredients_that_may_be_from_palm_oil_n;
    }

    /**
     * @return integer
     */
    public function getIngredientsThatMayBeFromPalmOilN()
    {
      return $this->ingredients_that_may_be_from_palm_oil_n;
    }

    //Add a method to calculate the count of product which can contents palm oil

    /**
     * @param Additives $additive
     */
    public function addAdditive(Additives $additive)
    {
      $this->additives[] = $additive;
    }

    /**
     * @param Additives $additive
     */
    public function removeAdditive(Additives $additive)
    {
      $this->additives->removeElement($additive);
    }

    /**
     * @return \Array
     */
     public function getAdditives()
     {
       return $this->additives;
     }

     /**
      * @param Brands $brand
      */
     public function setBrand(Brands $brand)
     {
       $this->brand = $brand;
     }

     /**
      * @return Brands
      */
     public function getBrand()
     {
       return $this->brand;
     }

     /**
      * @param Countries $country
      */
     public function setCountry(Countries $country)
     {
       $this->country = $country;
     }

    /**
     * @return Countries
     */
    public function getCountry()
    {
      return $this->country;
    }

    /**
     * @param Ingredients $ingredient
     */
    public function addIngredient(Ingredients $ingredient)
    {
      $this->ngredients[] = $ingredient;
    }

    /**
     * @param Ingredients $ingredient
     */
    public function removeIngredient(Ingredients $ingredient)
    {
      $this->ingredients->removeElement($ingredient);
    }

    /**
     * @return \Array
     */
     public function getIngredients()
     {
       return $this->ingredients;
     }

     /**
      * @param NutritionalInformation $nutritional_information
      */
     public function setNutritionalInformation(NutritionalInformation $nutritional_information = null)
     {
       $this->nutritional_information = $nutritional_information;
     }

    /**
     * @return NutritionalInformation
     */
    public function getNutritionalInformation()
    {
      return $this->nutritional_information;
    }
}
