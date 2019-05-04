<?php namespace App\Model;

use Doctrine\ORM\Mapping\Entity as Entity;
use Doctrine\ORM\Mapping\Column as Column;
use Doctrine\ORM\Mapping\Table as Table;
use Doctrine\ORM\Mapping\GeneratedValue as GeneratedValue;
use Doctrine\ORM\Mapping\Id as Id;

/**
 * @Entity @Table(name="customers")
 **/
class Customer
{
    /** @Id @Column(type="integer") @GeneratedValue **/
    protected $id;
    /**
     * @Column(type="string")
     **/
    protected $name;
    /** @Column(type="string", unique=true) **/
    protected $password;

    private $newPassword;

    private $confirmPassword;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return String
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param String $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @param String $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return String
     */
    public function getConfirmPassword()
    {
        return $this->confirmPassword;
    }

    /**
     * @param String $confirmPassword
     */
    public function setConfirmPassword($confirmPassword): void
    {
        $this->confirmPassword = $confirmPassword;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param mixed $newPassword
     */
    public function setNewPassword($newPassword): void
    {
        $this->newPassword = $newPassword;
    }



    public function __toString()
    {
        return "{ name " . $this->getName() . " }";
    }
}