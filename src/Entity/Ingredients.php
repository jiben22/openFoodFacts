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

//* @ORM\Column(name="ingredient", type="string", length=54)
    /**
     * @ORM\Column(name="ingredient", type="text")
     */
    private $ingredient;

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param string $ingredient
     */
    public function setIngredient($ingredient)
    {
      $this->ingredient = $ingredient;
    }

    /**
     * @return string
     */
    public function getIngredient()
    {
      return $this->ingredient;
    }
}
