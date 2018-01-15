<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    /**
     * @ORM\Column(type="integer")
     */
    private $nbErreur;
    /**
     * @ORM\Column(type="integer")
     */
    private $nbErreurGrave;
    // add your own fields
}
