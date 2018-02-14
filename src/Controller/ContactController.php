<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 31/01/2018
 * Time: 09:16
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Response;
use App\Model\Contact;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Services\ContactSessionManager;

class ContactController extends Controller
{
    /**
     * @Route("/contacts", name="contacts")
     */
    public function index(ContactSessionManager $session)
    {
        //$session->insert(new Contact());
        $contacts=$session->getAll();
        return $this->render("contact/contacts.html.twig", ["liste"=>$session->getAll()]);
    }

    /**
     * @Route("/contact/new", name="contact/new")
     */
    public function new(ContactSessionManager $session, Request $request)
    {
        // create a task and give it some dummy data for this example
        $contact = new Contact();

        $form = $this->createFormBuilder($contact)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email',EmailType::class)
            ->add('tel',TextType::class)
            ->add('mobile',TextType::class)
            ->add('save',SubmitType::class,['label'=>"Envoyer"])
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $contact=$form->getData();
            $manage= $this->getDoctrine()->getManager();
            $manage->persist($contact);
            $manage->flush($contact);

            return $this->redirectToRoute('contacts',['ContactManager'=>$session]);
        }

        return $this->render('contact/new.html.twig', array('form' => $form->createView(),));
    }

    /**
     * @Route("/contact/edit/{index}", name="contact/edit")
     */
    public function contactUpdate($index=null, ContactSessionManager $session, Request $request)
    {
            $contact =$session->get($index);
            $form = $this->createFormBuilder($contact)
                ->add('nom', TextType::class)
                ->add('prenom', TextType::class)
                ->add('email',EmailType::class)
                ->add('tel',TextType::class)
                ->add('mobile',TextType::class)
                ->add('save',SubmitType::class,['label'=>"Envoyer"])
                ->getForm();
            $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $contactModif=$form->getData();
            $donnee = [
                'nom'=>$contactModif->getNom(),
                'prenom'=>$contactModif->getPrenom(),
                'tel'=>$contactModif->getTel(),
                'email'=>$contactModif->getEmail(),
                'mobile'=>$contactModif->getMobile(),
            ];

            $session->update($contact,$donnee);
            return $this->redirectToRoute('contacts',['ContactManager'=>$session]);
        }

        return $this->render('contact/new.html.twig', array('form' => $form->createView(),));
    }

    /**
     * @Route("/contact/display/{index}", name="contact/display")
     */
    public function contactDisplay($index=null, ContactSessionManager $session)
    {
        $contact =$session->get($index);
        return $this->render("contact/contact.html.twig", ["contact"=>$contact,"index"=>$index]);
    }

    /**
     * @Route("/contact/delete", name="contact/delete")
     */
    public function contactDelete(ContactSessionManager $session)
    {
        $session->deletes(array($_POST["index"]));
        return $this->redirectToRoute('contacts', ['contactManager'=>$session]);
    }

    /**
     * @Route("/contact/search", name="contact/search")
     */
    public function contactSearch(ContactSessionManager $session)
    {
        $filtre = $_POST['filtre'];
        $contacts = $session->filterBy($filtre);
        return $this->render("contact/contacts.html.twig", ["liste"=>$contacts]);
    }
}