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
     * @ORM\Column(name="code", type="bigint", nullable=true)
     */
    private $code;

    /**
     * @ORM\Column(name="url", type="string", length=255, nullable=true)
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
     * @ORM\Column(name="product_name", type="string", length=255, nullable=true)
     */
    private $product_name;

    /**
     * @ORM\Column(name="serving_size", type="string", length=128, nullable=true)
     */
    private $serving_size;

    /**
     * @ORM\Column(name="additives_n", type="decimal", precision=5, nullable=true)
     */
    //private $additives_n;

    /**
     * @ORM\Column(name="ingredients_from_palm_oil_n", type="decimal", precision=5, nullable=true)
     */
    private $ingredients_from_palm_oil_n;

    /**
     * @ORM\Column(name="ingredients_that_may_be_from_palm_oil_n", type="decimal", precision=5, nullable=true)
     */
    private $ingredients_that_may_be_from_palm_oil_n;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Additives", cascade={"persist"})
     */
    private $additives;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brands", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Countries", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Ingredients", cascade={"persist"})
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
     * @param bigint $code
     */
    public function setCode($code)
    {
      $this->code = $code;
    }

    /**
     * @return bigint
     */
    public function getCode()
    {
      return $this->code;
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
     * @param integer $additives_n
     */
    public function setAdditivesN($additives_n = null)
    {
      if($additives_n == "")
      {
          $additives_n = null;
      }
      $this->additives_n = $additives_n;
    }

    /**
     * @return integer
     */
     /*
    public function getAdditivesN()
    {
      return $this->additives_n;
    }
    */

    //Add a method to calculate the number of additives

    /**
     * @param integer $ingredients_from_palm_oil_n
     */
    public function setIngredientsFromPalmOilN($ingredients_from_palm_oil_n = null)
    {
      if($ingredients_from_palm_oil_n == "")
      {
          $ingredients_from_palm_oil_n = null;
      }
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
     * @param decimal $ingredients_that_may_be_from_palm_oil_n
     */
    public function setIngredientsThatMayBeFromPalmOilN($ingredients_that_may_be_from_palm_oil_n = null)
    {
      if($ingredients_that_may_be_from_palm_oil_n == "")
      {
          $ingredients_that_may_be_from_palm_oil_n = null;
      }
      $this->ingredients_that_may_be_from_palm_oil_n = $ingredients_that_may_be_from_palm_oil_n;
    }

    /**
     * @return decimal
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
      $this->additives[0] = $additive;
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
      * @return string
      */
     public function viewBrand()
     {
       return $this->getBrand()->getBrand();
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
      $this->ingredients[0] = $ingredient;
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
