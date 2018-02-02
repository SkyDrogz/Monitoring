<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InfoProtectRepository")
 */
class InfoProtect
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
    private $email;
    /**
     * @ORM\Column(type="string")
     */
    private $URL;


    public function getIdentifiant()
    {
        return $this->identifiant;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getUrl()
    {
        return $this->URL;
    }

    // add your own fields
}
