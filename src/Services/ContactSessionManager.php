<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 31/01/2018
 * Time: 08:54
 */

namespace App\Services;


use App\Model\Contact;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ContactSessionManager implements IModelManager
{
    private $session;

    private function updateSession($values)
    {
        $this->session->set('contacts',$values);
    }

    public function __construct(SessionInterface $sess)
    {
        $this->session = $sess;
    }

    public function getAll()
    {
        return $this->session->get("contacts",[]);
    }

    public function insert(Contact $o)
    {
        $users = $this->getAll();
        $users[] = $o;
        $this->updateSession($users);
    }

    public function update($object, $values) {
        $contacts = $this->session->get("contacts");
        foreach($contacts as $cle=>$contact){
            if($contact->equals($object)){
                foreach($values as $keyV => $valeur){
                    $method = 'set'.ucfirst($keyV);
                    $contact->$method($valeur);
                }
            }
        }
    }

    public function deletes($indexes)
    {
        $contacts = $this->session->get("contacts");
        foreach($indexes as $index){
            $contacts[$index] = null;
        }
        $i=0;
        $nouveauxContacts=null;
        foreach($contacts as $key=>$contact){
            if($contact!=null){
                $nouveauxContacts[$i]=$contact;
            }
        }
        $this->updateSession($nouveauxContacts);
    }

    public function select($i)
    {
        $this->session->set("indexContacts", $i);
    }

    public function get($i)
    {
        $contacts = $this->session->get("contacts");
        return $contacts[$i];
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

    public function count()
    {
        return sizeof($this->session);
    }
}