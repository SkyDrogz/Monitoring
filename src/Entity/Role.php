<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 */
class Role
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(name="nom_role", type="string")
     */
    private $nomRole;

    public function getNomRole ()
    {
        return $this->nomRole;
    }
    public function getId()
    {
        return $this->id;
    }
    public function setNomRole($nomRole)
    {
        $this->$nomRole = $nomRole;
    }
    public function setId($id)
    {
        $this->$id = $id;
    }
    // add your own fields
}
