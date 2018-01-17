<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SystemeRepository")
 */
class Systeme
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
    private $nomSysteme;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $etat;
    /**
     * @ORM\Column(type="string")
     */
    private $url;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $diagnostic;
    /**
     * @ORM\Column(type="boolean",options={"default"=true})
     */
    private $actif;

    
    public function __construct(){
        $this->actif = true;
    }



    //Getter
    public function getNom()
    {
        return $this->nomSysteme;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getURL()
    {
        return $this->url;
    }
    public function getActif()
    {
        return $this->actif;
    }
    //Setter
    public function setNom($nomSysteme)
    {
        $this->nomSysteme = $nomSysteme;
    }
    public function setURL($url)
    {
        $this->url = $url;
    }
    public function setActif($actif)
    {
        $this->actif=$actif;
    }
}
