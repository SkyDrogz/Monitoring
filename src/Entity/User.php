<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Role;

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
     * @ORM\Column(type="date")
     */
    private $dateConnexion;
    /**
     * @ORM\Column(type="date")
     */
    private $dateDeconnexion;
    
    public function getId()
    {
        return $this->id;
    }
    public function getIdentifiant()
    {
        return $this->identifiant;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function getDateConnexion()
    {
        return $this->dateConnexion;
    }
    public function getDateDeconnexion()
    {
        return $this->dateDeconnexion;
    }
    public function setIdentifiant($identifiant)
    {
         $this->identifiant = $identifiant;
    }
    public function setPassword($password)
    {
         $this->password = $password;
    }
    public function setRole($role)
    {
         $this->role = $role;
    }
    public function setdateConnexion($dateConnexion)
    {
         $this->dateConnexion = $dateConnexion;
    }
    public function setDateDeconnexion($dateDeconnexion)
    {
         $this->dateDeconnexion = $dateDeconnexion;
    }
}
