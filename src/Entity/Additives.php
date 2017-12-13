<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdditivesRepository")
 */
class Additives
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="additives_n", type="integer")
     */
    private $additives_n;

    /**
     * @return string
     */
    public function getAdditivesN()
    {
      return $this->additives_n;
    }

    /**
     * @param string $additives_n
     */
    public function setAdditivesN($additives_n)
    {
      $this->additives_n = $additives_n;
    }

    /**
     * @ORM\Column(name="additives_fr", type="string", length=20)
     */
    private $additives_fr;

    /**
     * @return string
     */
    public function getAdditivesFr()
    {
      return $this->additives_fr;
    }

    /**
     * @param string $additives_fr
     */
    public function setAdditivesFr($additives_fr)
    {
      $this->additives_fr = $additives_fr;
    }
}

