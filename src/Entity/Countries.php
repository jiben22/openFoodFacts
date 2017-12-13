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
     * @ORM\Column(name="CountriesRepository_fr", type="string", length=32)
     */
    private $country_fr;

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
    public function setCountrysFr($country_fr)
    {
      $this->country_fr = $country_fr;
    }

    /**
     * @return string
     */
    public function getCountryFr()
    {
      return $this->country_fr;
    }
}
