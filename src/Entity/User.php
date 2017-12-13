<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="user_name", type="string", length=20)
     */
    private $user_name;

    /**
     * @ORM\Column(name="user_password", type="string", length=20)
     */
    private $password;

    /**
     * @ORM\Column(name="user_mail", type="string", length=50)
     */
    private $user_mail;

    /**
     * @return int
     */
    public function getId()
    {
      return $this->id;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
      return $this->user_name;
    }

    /**
     * @param string $user_name
     */
    public function setUserName($user_name)
    {
      $this->user_name = $user_name;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
      return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
      $this->password = $password;
    }

    /**
     * @return string
     */
    public function getUserMail()
    {
      return $this->user_mail;
    }

    /**
     * @param string $user_mail
     */
    public function setUserMail($user_mail)
    {
      $this->user_mail = $user_mail;
    }

}

