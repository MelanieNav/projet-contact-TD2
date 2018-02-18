<?php

namespace App\Repository;

use App\Entity\Contact;
use App\Services\IModelManager;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ContactRepository extends ServiceEntityRepository
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
        return $this->insert($o);
    }

    public function update($contact, $object)
    {
        foreach ($contact as $key=>$value)
        {
            $assesseur = "set".$key;
            if(method_exists($object,$assesseur))
            {
                $contact->$assesseur($value);
            }
        }
        $this->_em->flush();
    }

    public function deletes($i)
    {
        /*$keys = array_map(function($i)
        {
            return 'id='.$i;
        },$i);
        $keys = implode(" or ",$i);*/
        $keys = 'id='.$i;
        $query = $this->_em->createQuery("DELETE FROM CONTACT WHERE ".$keys);
        $query->execute();

        $contacts=$this->findBy($keys);
        foreach ($contacts as $contact){
            $this->_em->remove($contact);
        }

    }

    public function select($i)
    {

    }

    public function get($i)
    {
        return $this->findOneBy(array('id' => $i));
    }

    public function filterBy($o)
    {
        $users = $this->getAll();
        $selectionne = array();
        foreach ($users as $cle=>$contact)
        {
            $a = preg_match("/$o/",$contact->getNom());
            $b = preg_match("/$o/",$contact->getPrenom());
            $c = preg_match("/$o/",$contact->getTel());
            $d = preg_match("/$o/",$contact->getEmail());
            $e = preg_match("/$o/",$contact->getMobile());

            if($a or $b or $c or $d or $e)
                $selectionne[] = $contact;
        }

        return $selectionne;
    }
}
