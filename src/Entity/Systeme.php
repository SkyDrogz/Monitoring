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
     * @ORM\Column(type="text")
     */
    private $nomSysteme;
    /**
     * @ORM\Column(type="text")
     */
    private $etat;
    /**
     * @ORM\Column(type="text")
     */
    private $url;
    /**
     * @ORM\Column(type="text")
     */
    private $diagnostic;
    // add your own fields



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
    //Setter
    public function setNom($nomSysteme)
    {
        $this->nomSysteme = $nomSysteme;
    }
    public function setURL($url)
    {
        $this->url = $url;
    }
}
