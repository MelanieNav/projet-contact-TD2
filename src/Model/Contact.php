<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 31/01/2018
 * Time: 08:54
 */

namespace App\Model;


class Contact
{
    private $nom;
    private $prenom;
    private $tel;
    private $email;
    private $mobile;

    public function __construct($nom='', $prenom='', $tel='', $email='',$mobile=''){
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->tel  = $tel;
        $this->email = $email;
        $this->mobile = $mobile;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
    }

    /**
     * @param string $tel
     */
    public function setTel(string $tel): void
    {
        $this->tel = $tel;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $mobile
     */
    public function setMobile(string $mobile): void
    {
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
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @return string
     */
    public function getTel(): string
    {
        return $this->tel;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function equals($o) : bool
    {
        if($this->nom == $o->getNom() && $this->prenom == $o->getPrenom() && $this->email == $o->getEmail() && $this->tel == $o->getTel() && $this->mobile == $o->getMobile())
            return true;
        return false;
    }
}