<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\ContactForm;
use AppBundle\Entity\JoinUs;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/home.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ));
    }

    /**
     * @Route("/poznan", name="poznan")
     */
    public function poznanPage(Request $request)
    {
      $post = new JoinUs();
      $formJoin = $this->createFormBuilder($post)
                  ->setMethod('GET')
                  ->add('company','text',['label' => 'Nazwa firmy'])
                  ->add('name','text', ['label' => 'Imię i nazwisko osoby kontaktowej'])
                  ->add('phone','integer', ['label' => 'Numer telefonu osoby kontaktowej'])
                  ->add('email','text', ['label' => 'Adres email osoby kontaktowej'])
                  ->add('teams','integer', ['label' => 'Liczba zgłoszonych zespołów'])
                  ->add('invoice','text', ['label' => 'Dane do faktury'])
                  ->add('payment','integer', ['label' => 'Płatność'])
                  ->add('save','submit', ['label' => 'Wyślij'])
                  ->getForm();
      $formJoin->handleRequest($request);
          if ($formJoin->isSubmitted()) {
          $post = $formJoin->getData();
          $em = $this->getDoctrine()->getManager();
          $em->persist($post);
          $em->flush();

          return $this->redirectToRoute('poznan');
        }

     return $this->render('default/poznan.html.twig', ['form' => $formJoin->createView()]);
    }
  

    /**
     * @Route("/onas", name="onas")
     */
     public function ContactFormAction(Request $request){
       $post = new ContactForm();
       $form = $this->createFormBuilder($post)
                   ->setMethod('GET')
                   ->add('email','text',['label' => 'Adres e-mail'])
                   ->add('name','text', ['label' => 'Imię'])
                   ->add('message','text', ['label' => 'Wiadomość'])
                   ->add('save','submit', ['label' => 'Wyślij'])
                   ->getForm();
      $email = 'form[email]';
      $name = 'form[name]';
      $message = 'form[message]';
      mail('meetnight@meetnight.pl', 'Offsight Kontakt', 'Wiadomość');
       $form->handleRequest($request);
           if ($form->isSubmitted()) {
           $post = $form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($post);
           $em->flush();

           return $this->redirectToRoute('onas');
         }

      return $this->render('default/aboutus.html.twig', ['form' => $form->createView()]);
     }
}
