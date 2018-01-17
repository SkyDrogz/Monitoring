<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EntrepriseRepository")
 */
class Entreprise
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
    private $libelle;
<<<<<<< HEAD
    /**
    * @ORM\ManyToMany(targetEntity="Systeme", cascade={"persist"})
   */
   private $systeme;
    // add your own fields
=======
     /**
     * @ORM\Column(type="boolean",options={"default"=true})
     */
    private $actif;

    
    public function __construct(){
        $this->actif = true;
    }

    public function getId()
    {
       return $this ->id;
    }
    public function getLibelle()
    {
        return $this ->libelle;
    }
    public function getActif()
    {
        return $this ->actif;
    }
    public function setId ($id)
    {
        $this->id=$id;
    }
    public function setLibelle($libelle)
    {
        $this->libelle=$libelle;
    }
    public function setActif($actif)
    {
        $this->actif=$actif;
    }
    
>>>>>>> 9de9f34979f806c677804fc9e0dc942446aaf7a3
}
