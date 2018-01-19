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
     * @ORM\Column(type="string",nullable=true)
     */
    private $requete;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $resultatAttendu;
    /**
     * @ORM\Column(type="boolean",options={"default"=true})
     */
    private $actif;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategSysteme")
     */
    private $categSysteme;
     /**
     * @ORM\Column(type="dateTime",nullable=true)
     */
    private $dateOffline;
     /**
     * @ORM\Column(type="integer",nullable=false)
     */
    private $repetition;



    public function __construct(){
        $this->actif = true;
    }



    //Getter
    public function getRequete()
    {
      return $this->requete;
    }
    public function getResultatAttendu()
    {
      return $this->resultatAttendu;
    }
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
    public function getEtat()
    {
        return $this->etat;
    }
    public function getCategSysteme()
    {
        return $this->categSysteme;
    }
    //Setter
    public function setRequete($requete)
    {
      $this->requete = $requete;
    }
    public function setNom($nomSysteme)
    {
        $this->nomSysteme = $nomSysteme;
    }
    public function setURL($url)
    {
        $this->url = $url;
    }
    public function setEtat($etat)
    {
        $this->etat=$etat;
    }
    public function setActif($actif)
    {
        $this->actif=$actif;
    }
    public function setCategSysteme($categSysteme)
    {
        $this->categSyteme=$categSysteme;
    }
}
