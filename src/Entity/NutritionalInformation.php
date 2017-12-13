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
     * @ORM\Column(name="nutrition_grade_fr", type="string", length=1)
     */
    private $nutrition_grade_fr;

    /**
     * @ORM\Column(name="energy_100g", type="integer")
     */
    private $energy_100g;

    /**
     * @ORM\Column(name="fat_100g",type="decimal", precision=5, scale=2)
     */
    private $fat_100g;

    /**
     * @ORM\Column(name="saturated_fat_100g",type="decimal", precision=5, scale=2)
     */
    private $saturated_fat_100g;

    /**
     * @ORM\Column(name="cholesterol_100g",type="decimal", precision=6, scale=5)
     */
    private $cholesterol_100g;

    /**
     * @ORM\Column(name="carbohydrates_100g",type="decimal", precision=5, scale=2)
     */
    private $carbohydrates_100g;

    /**
     * @ORM\Column(name="sugars_100g",type="decimal", precision=5, scale=2)
     */
    private $sugars_100g;

    /**
     * @ORM\Column(name="fiber_100g",type="decimal", precision=4, scale=1)
     */
    private $fiber_100g;

    /**
     * @ORM\Column(name="proteins_100g",type="decimal", precision=5, scale=2)
     */
    private $proteins_100g;

    /**
     * @ORM\Column(name="salt_100g",type="decimal", precision=6, scale=5)
     */
    private $salt_100g;

    /**
     * @ORM\Column(name="sodium_100g",type="decimal", precision=4, scale=3)
     */
    private $sodium_100g;

    /**
     * @ORM\Column(name="vitamin_a_100g",type="decimal", precision=8, scale=7)
     */
    private $vitamin_a_100g;

    /**
     * @ORM\Column(name="calcium_100g",type="decimal", precision=4, scale=3)
     */
    private $calcium_100g;

    /**
     * @ORM\Column(name="iron_100g",type="decimal", precision=6, scale=5)
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
    public function setNutritionGradeFr($nutrition_grade_fr)
    {
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
     * @param integer $energy_100g
     */
    public function setEnergy100g($energy_100g)
    {
      $this->energy_100g = $energy_100g;
    }

    /**
     * @return integer
     */
    public function getEnergy100g()
    {
      return $this->energy_100g;
    }

    /**
     * @param decimal $fat_100g
     */
    public function setFat100g($fat_100g)
    {
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
    public function setSaturatedFat100g($saturated_fat_100g)
    {
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
    public function setCholesterol100g($cholesterol_100g)
    {
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
    public function setCarbohydrates100g($carbohydrates_100g)
    {
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
    public function setSugars100g($sugars_100g)
    {
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
    public function setFiber100g($fiber_100g)
    {
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
    public function setProteins100g($proteins_100g)
    {
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
    public function setSalt100g($salt_100g)
    {
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
    public function setSodium100g($sodium_100g)
    {
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
    public function setVitaminA100g($vitamin_a_100g)
    {
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
    public function setCalcium100g($calcium_100g)
    {
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
    public function setIron100g($iron_100g)
    {
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
