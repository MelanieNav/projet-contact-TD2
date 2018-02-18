<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", length=30)
     */
    private $id;

    // add your own fields

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom;
    /**
     * @ORM\Column(type="string", length=30)
     */
    private $prenom;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $email;


    public function __construct($nom='', $prenom='', $tel='', $email='',$mobile=''){
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->tel  = $tel;
        $this->email = $email;
        $this->mobile = $mobile;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * @param mixed $tel
     */
    public function setTel($tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile): void
    {
        $this->mobile = $mobile;
    }
    /**
     * @ORM\Column(type="string", length=10)
     */
    private $tel;
    /**
     * @ORM\Column(type="string", length=10)
     */
    private $mobile;
}
