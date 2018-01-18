<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategSystemeRepository")
 */
class CategSysteme
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\categorie
     * @ORM\Column(type="string")
     */
    private $categorie;

    public function getId()
    {
        return $this->id;
    }
    public function getCategorie()
    {
        return $this->categorie;
    }
    public function setId($id){
        $this->id=$id;
    }
    public function setCategorie($categorie){
        $this->categorie=$categorie;
    }
    // add your own fields
}
