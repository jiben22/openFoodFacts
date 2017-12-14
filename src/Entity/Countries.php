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
     * @ORM\Column(name="Country_fr", type="string", length=64, nullable=true)
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
     * @param string $country_fr
     */
    public function setCountryFr($country_fr)
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
