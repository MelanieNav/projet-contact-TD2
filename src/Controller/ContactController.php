<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 31/01/2018
 * Time: 09:16
 */

namespace App\Controller;

use App\Repository\ContactRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Contact;
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
        $contacts = $this->getDoctrine()->getManager()->getRepository(Contact::class)->findAll();
        return $this->render("contact/contacts.html.twig", ["liste"=>$contacts]);
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

            $manage = $this->getDoctrine()->getManager();
            $manage->persist($contact);
            $manage->flush();

            return $this->redirectToRoute('contacts',['ContactManager'=>$session]);
        }

        return $this->render('contact/new.html.twig', array('form' => $form->createView(),));
    }

    /**
     * @Route("/contact/edit/{index}", name="contact/edit")
     */
    public function contactUpdate($index=null, ContactRepository $contactRepo, Request $request)
    {
            $contact =$contactRepo->get($index);

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
            /*$em = $this->getDoctrine()->getManager();
            $contact = $em->getRepository(Contact::class)->find($index);
            $index = $request->get("id");
            $contact = $contactRepo->get($index);*/
            $contactModif=$form->getData();
            $donnee = [
                'nom'=>$contactModif->getNom(),
                'prenom'=>$contactModif->getPrenom(),
                'tel'=>$contactModif->getTel(),
                'email'=>$contactModif->getEmail(),
                'mobile'=>$contactModif->getMobile(),
            ];

            /* Fonctionne bien mais n'utilise pas le ContactRepository
             *
            $contact->setNom($donnee['nom']);
            $contact->setPrenom($donnee['prenom']);
            $contact->setTel($donnee['tel']);
            $contact->setEmail($donnee['email']);
            $contact->setMobile($donnee['mobile']);
            $this->getDoctrine()->getManager()->flush();*/

            $contactRepo->update($contact,$donnee);
            return $this->redirectToRoute('contacts',['ContactManager'=>$contactRepo]);
        }

        return $this->render('contact/new.html.twig', array('form' => $form->createView(),));
    }

    /**
     * @Route("/contact/display/{index}", name="contact/display")
     */
    public function contactDisplay($index)
    {
        //$contact = $this->getDoctrine()->getManager()->getRepository(Contact::class)->find(["id"=>$index]);
        $contact = $this->getDoctrine()->getManager()->getRepository(Contact::class)->findOneBy(["id"=>$index]);
        return $this->render("contact/contact.html.twig", ["contact"=>$contact,"index"=>$index]);
    }

    /**
     * @Route("/contact/delete", name="contact/delete")
     */
    public function contactDelete(ContactRepository $contactRepo)
    {
        $contact = $contactRepo->findOneBy(array('id'=>$_POST['index']));

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($contact);
        $em->flush();

        //$contactRepo->deletes($_POST["index"]);
        return $this->redirectToRoute('contacts', ['contactManager'=>$contactRepo]);
    }

    /**
     * @Route("/contact/search", name="contact/search")
     */
    public function contactSearch(ContactRepository $contactRepo)
    {
        $filtre = $_POST['filtre'];
        $contacts = $contactRepo->filterBy($filtre);
        return $this->render("contact/contacts.html.twig", ["liste"=>$contacts]);
    }
}