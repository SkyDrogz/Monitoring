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
     * @ORM\Column(type="text")
     */
    private $identifiant;
    /**
     * @ORM\Column(type="text")
     */
    private $password;
    /**
     * @ORM\Column(type="text")
     */
    private $role;
    /**
     * @ORM\Column(type="dateTime")
     */
    private $dateConnexion;
    /**
     * @ORM\Column(type="dateTime")
     */
    private $dateDeconnexion;
    
    // add your own field
}
