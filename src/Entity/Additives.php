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
     * @ORM\Column(name="additive_fr", type="text", nullable=true)
     */
    private $additive_fr;

    /**
     * @param string $additive_fr
     */
    public function setAdditiveFr($additive_fr = null)
    {
      $this->additive_fr = $additive_fr;
    }

    /**
     * @return string
     */
    public function getAdditiveFr()
    {
      return $this->additive_fr;
    }
}
