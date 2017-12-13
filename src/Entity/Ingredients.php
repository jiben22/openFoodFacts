<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\IngredientsRepository")
 */
class Ingredients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="ingredients_text", type="text")
     */
    private $ingredients_text;

    /**
     * @ORM\Column(name="ingredients_from_palm_oil", type="integer")
     */
    private $ingredients_from_palm_oil;

    /**
     * @ORM\Column(name="ingredients_that_may_be_from_palm_oil", type="integer")
     */
    private $ingredients_that_may_be_from_palm_oil;

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param text $ingredients_text
     */
    public function setIngredientsText($ingredients_text)
    {
      $this->ingredients_text = $ingredients_text;
    }

    /**
     * @return text
     */
    public function getIngredientsText()
    {
      return $this->ingredients_text;
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
