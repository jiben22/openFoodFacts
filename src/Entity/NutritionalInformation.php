<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NutritionalInformationRepository")
 */
class NutritionalInformation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="nutrition_grade_fr", type="string", length=10, nullable=true)
     */
    private $nutrition_grade_fr;

    /**
     * @ORM\Column(name="energy_100g", type="decimal", precision=10, nullable=true)
     */
    private $energy_100g;

    /**
     * @ORM\Column(name="fat_100g",type="decimal", precision=10, scale=2, nullable=true, nullable=true)
     */
    private $fat_100g;

    /**
     * @ORM\Column(name="saturated_fat_100g",type="decimal", precision=10, scale=2, nullable=true)
     */
    private $saturated_fat_100g;

    /**
     * @ORM\Column(name="cholesterol_100g",type="decimal", precision=10, scale=5, nullable=true)
     */
    private $cholesterol_100g;

    /**
     * @ORM\Column(name="carbohydrates_100g",type="decimal", precision=10, scale=2, nullable=true)
     */
    private $carbohydrates_100g;

    /**
     * @ORM\Column(name="sugars_100g",type="decimal", precision=10, scale=2, nullable=true)
     */
    private $sugars_100g;

    /**
     * @ORM\Column(name="fiber_100g",type="decimal", precision=10, scale=1, nullable=true)
     */
    private $fiber_100g;

    /**
     * @ORM\Column(name="proteins_100g",type="decimal", precision=10, scale=2, nullable=true)
     */
    private $proteins_100g;

    /**
     * @ORM\Column(name="salt_100g",type="decimal", precision=10, scale=5, nullable=true)
     */
    private $salt_100g;

    /**
     * @ORM\Column(name="sodium_100g",type="decimal", precision=10, scale=3, nullable=true)
     */
    private $sodium_100g;

    /**
     * @ORM\Column(name="vitamin_a_100g",type="decimal", precision=10, scale=7, nullable=true)
     */
    private $vitamin_a_100g;

    /**
     * @ORM\Column(name="calcium_100g",type="decimal", precision=10, scale=3, nullable=true)
     */
    private $calcium_100g;

    /**
     * @ORM\Column(name="iron_100g",type="decimal", precision=10, scale=5, nullable=true)
     */
    private $iron_100g;

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param string $nutrition_grade_fr
     */
    public function setNutritionGradeFr($nutrition_grade_fr = null)
    {
      if($nutrition_grade_fr == "") //TO MAKE: Validation for attribute it's a letter not an other type
      {
          $nutrition_grade_fr = null;
      }
      $this->nutrition_grade_fr = $nutrition_grade_fr;
    }

    /**
     * @return string
     */
    public function getNutritionGradeFr()
    {
      return $this->nutrition_grade_fr;
    }

    /**
     * @param decimal $energy_100g
     */
    public function setEnergy100g($energy_100g = null)
    {
      if($energy_100g == "")
      {
          $energy_100g = null;
      }
      $this->energy_100g = $energy_100g;
    }

    /**
     * @return decimal
     */
    public function getEnergy100g()
    {
      return $this->energy_100g;
    }

    /**
     * @param decimal $fat_100g
     */
    public function setFat100g($fat_100g = null)
    {
      if($fat_100g == "")
      {
          $fat_100g = null;
      }
      $this->fat_100g = $fat_100g;
    }

    /**
     * @return decimal
     */
    public function getFat100g()
    {
      return $this->fat_100g;
    }

    /**
     * @param decimal $saturated-fat_100g
     */
    public function setSaturatedFat100g($saturated_fat_100g = null)
    {
      if($saturated_fat_100g == "")
      {
          $saturated_fat_100g = null;
      }
      $this->saturated_fat_100g = $saturated_fat_100g;
    }

    /**
     * @return decimal
     */
    public function getSaturatedFat100g()
    {
      return $this->saturated_fat_100g;
    }

    /**
     * @param decimal $cholesterol_100g
     */
    public function setCholesterol100g($cholesterol_100g = null)
    {
      if($cholesterol_100g == "")
      {
          $cholesterol_100g = null;
      }
      $this->cholesterol_100g = $cholesterol_100g;
    }

    /**
     * @return decimal
     */
    public function getCholesterol100g()
    {
      return $this->cholesterol_100g;
    }

    /**
     * @param decimal $carbohydrates_100g
     */
    public function setCarbohydrates100g($carbohydrates_100g = null)
    {
      if($carbohydrates_100g == "")
      {
          $carbohydrates_100g = null;
      }
      $this->carbohydrates_100g = $carbohydrates_100g;
    }

    /**
     * @return decimal
     */
    public function getCarbohydrates100g()
    {
      return $this->carbohydrates_100g;
    }

    /**
     * @param decimal $sugars_100g
     */
    public function setSugars100g($sugars_100g = null)
    {
      if($sugars_100g == "")
      {
          $sugars_100g = null;
      }
      $this->sugars_100g = $sugars_100g;
    }

    /**
     * @return decimal
     */
    public function getSugars100g()
    {
      return $this->sugars_100g;
    }

    /**
     * @param decimal $fiber_100g
     */
    public function setFiber100g($fiber_100g = null)
    {
      if($fiber_100g == "")
      {
          $fiber_100g = null;
      }
      $this->fiber_100g = $fiber_100g;
    }

    /**
     * @return decimal
     */
    public function getFiber100g()
    {
      return $this->fiber_100g;
    }

    /**
     * @param decimal $proteins_100g
     */
    public function setProteins100g($proteins_100g = null)
    {
      if($proteins_100g == "")
      {
          $proteins_100g = null;
      }
      $this->proteins_100g = $proteins_100g;
    }

    /**
     * @return decimal
     */
    public function getProteins100g()
    {
      return $this->proteins_100g;
    }

    /**
     * @param decimal $salt_100g
     */
    public function setSalt100g($salt_100g = null)
    {
      if($salt_100g == "")
      {
          $salt_100g = null;
      }
      $this->salt_100g = $salt_100g;
    }

    /**
     * @return decimal
     */
    public function getSalt100g()
    {
      return $this->salt_100g;
    }

    /**
     * @param decimal $sodium_100g
     */
    public function setSodium100g($sodium_100g = null)
    {
      if($sodium_100g == "")
      {
          $sodium_100g = null;
      }
      $this->sodium_100g = $sodium_100g;
    }

    /**
     * @return decimal
     */
    public function getSodium100g()
    {
      return $this->sodium_100g;
    }

    /**
     * @param decimal $vitamin_a_100g
     */
    public function setVitaminA100g($vitamin_a_100g = null)
    {
      if($vitamin_a_100g == "")
      {
          $vitamin_a_100g = null;
      }
      $this->vitamin_a_100g = $vitamin_a_100g;
    }

    /**
     * @return decimal
     */
    public function getVitaminA100g()
    {
      return $this->vitamin_a_100g;
    }

    /**
     * @param decimal $calcium_100g
     */
    public function setCalcium100g($calcium_100g = null)
    {
      if($calcium_100g == "")
      {
          $calcium_100g = null;
      }
      $this->calcium_100g = $calcium_100g;
    }

    /**
     * @return decimal
     */
    public function getCalcium100g()
    {
      return $this->calcium_100g;
    }

    /**
     * @param decimal $iron_100g
     */
    public function setIron100g($iron_100g = null)
    {
      if($iron_100g == "")
      {
          $iron_100g = null;
      }
      $this->iron_100g = $iron_100g;
    }

    /**
     * @return decimal
     */
    public function getIron100g()
    {
      return $this->iron_100g;
    }
}
