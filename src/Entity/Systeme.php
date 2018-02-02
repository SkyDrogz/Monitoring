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
     * @ORM\Column(type="datetime")
     */
    private $dateOffline;
     /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $repetition;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;
     /**
     * @ORM\Column(type="integer",nullable=true,options={"default"=1})
     */
    private $niveauUrgence;


    public function __construct(){
        $this->actif = true;
        $this->dateOffline = new \Datetime();
        $this->repetition =5;
    }



    //Getter
    public function getNiveauUrgence()
    {
        return $this->niveauUrgence;
    }
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
    public function getDateOffline()
    {
        return $this->dateOffline;
    }
    public function getRepetition()
    {
        return $this->repetition;
    }
    public function getUser()
    {
        return $this->user;
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
        $this->categSysteme=$categSysteme;
    }
    public function setDateOffline($dateOffline)
    {
        $this->dateOffline=$dateOffline;
    }
    public function setRepetition($repetition)
    {
        $this->repetition=$repetition;
    }
    public function setUser($user)
    {
        $this->user=$user;
    }
    public function setNiveauUrgence($niveauUrgence)
    {
        $this->niveauUrgence=$niveauUrgence;
    }
}
