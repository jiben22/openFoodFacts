<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CountriesRepository")
 */
class Countries
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="countries_fr", type="string", length=32)
     */
    private $countries_fr;

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @param string $countries_fr
     */
    public function setCountriesFr($countries_fr)
    {
      $this->countries_fr = $countries_fr;
    }

    /**
     * @return string
     */
    public function getCountriesFr()
    {
      return $this->countries_fr;
    }
}
