<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Services\IModelManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContactRepository extends ServiceEntityRepository implements IModelManager
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.something = :value')->setParameter('value', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
    public function getAll()
    {
        return $this->findAll();
    }

    public function insert(\App\Model\Contact $o)
    {
        $this->insert($o);
    }

    public function update($c, $o)
    {

    }

    public function deletes($i)
    {
        $keys=array_map(function($i){return 'id='.$i;},$i);
        $keys=implode("or",$i);
        $query=$this->_em->createQuery("DELETE FROM Contact c where".$keys);
        $query->execute();
       /* $contacts=$this->findBy($keys);
        foreach ($contacts as $contact){
            $this->_em->remove($contact);
        }*/
    }

    public function select($i)
    {

    }

    public function get($i)
    {
       return $this->findOneBy($i);
    }

    public function filterBy($o)
    {

    }

    public function size(){

    }
}
