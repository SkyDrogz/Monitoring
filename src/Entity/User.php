<?php

namespace App\Entity;
use Gedmo\Mapping\Annotation as Gedmo;
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
     * @ORM\Column(type="string")
     */
    private $identifiant;
    /**
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Role")
     * @ORM\JoinColumn(nullable=true)
     */
    private $role;
    /**
     * @ORM\Column(type="string")
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     */
    private $tel;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $dateConnexion;
    /**
     * @ORM\Column(type="date",nullable=true)
     */
    private $dateDeconnexion;
     /**
     * @ORM\Column(type="boolean",options={"default"=true})
     */
    private $actif;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Entreprise")
     * @ORM\JoinColumn(nullable=true)
     */
    private $entreprise;

    public function __construct(){
        $this->actif = true;
    }
    
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
    public function getActif()
    {
        return $this->actif;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getTel()
    {
        return $this->tel;
    }
    public function getEntreprise()
    {
        return $this->entreprise;
    }
    public function getNomRole ()
    {
        return $this->nomRole;
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
    public function setActif ($actif)
    {
         $this->actif = $actif;
    }
    public function setEmail ($email)
    {
        $this->email=$email;
    }
    public function setTel ($tel)
    {
        $this->tel=$tel;
    }
    public function setEntreprise ($entreprise)
    {
        $this->entreprise=$entreprise;
    }
}
