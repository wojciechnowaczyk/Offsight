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
                  ->add('company','text',['label' => 'Company'])
                  ->add('name','text', ['label' => 'B'])
                  ->add('phone','integer', ['label' => 'C'])
                  ->add('email','text', ['label' => 'D'])
                  ->add('teams','integer', ['label' => 'E'])
                  ->add('invoice','text', ['label' => 'F'])
                  ->add('payment','integer', ['label' => 'G'])
                  ->add('save','submit', ['label' => 'Wyślij'])
                  ->getForm();
      $formJoin->handleRequest($request);
          if ($formJoin->isSubmitted()) {
          $post = $formJoin->getData();
          $em = $this->getDoctrine()->getManager();
          $em->persist($post);
          $em->flush();
          //$message='Nowa firma zapisała się na Offsight Poznań. Wejdź do bazy danych, żeby sprawdzić.';
          //mail('meetnight@meetnight.pl', 'Offsight Firma', $message);

          $to = 'offsight@offsight.pl';

          $subject = 'Offsight | Nowa firma | Poznań';

          $headers = "From: offsight@meetnight.pl\r\n";
          $headers .= "Reply-To: offsight@meetnight.pl\r\n";
          $headers .= "Content-Type: text/html";

          $message = '<html><body>';
          $message .= '<img src="http://offsight.meetnight.pl/img/header.png" alt="Offsight" />';
          $message .= '<div style="text-align:center">';
          $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
          $message .= "<tr style='background: #eee;'><td><strong>Nazwa firmy</strong> </td><td>";
          $message .= $post->getCompany();
          $message .= "</td></tr>";
          $message .= "<tr><td><strong>Imię i nazwisko</strong> </td><td>";
          $message .= $post->getName();
          $message .= "</td></tr>";
          $message .= "<tr><td><strong>Numer telefonu</strong> </td><td>";
          $message .= $post->getPhone();
          $message .= "</td></tr>";
          $message .= "<tr><td><strong>E-mail</strong> </td><td>";
          $message .= $post->getEmail();
          $message .= "</td></tr>";
          $message .= "<tr><td><strong>Drużyny</strong> </td><td>";
          $message .= $post->getTeams();
          $message .= "</td></tr>";
          $message .= "<tr><td><strong>Dane do faktury</strong> </td><td>";
          $message .= $post->getInvoice();
          $message .= "</td></tr>";
          $message .= "<tr><td><strong>Płatność</strong> </td><td>";
          $message .= $post->getPayment();
          $message .= "</td></tr>";
          $message .= "</table>";
          $message .= "</div>";
          $message .= "</body></html>";
          mail($to, $subject, $message, $headers);

          $to2 = $post->getEmail();

          $subject2 = 'Offsight | Rejestracja';

          $headers2 = "From: offsight@offsight.pl\r\n";
          $headers2 .= "Reply-To: offsight@offsight.pl\r\n";
          $headers2 .= "Content-Type: text/html";

          $message2 = '<html><body>';
          $message2 .= '<img src="http://offsight.meetnight.pl/img/header.png" alt="Offsight" />';
          $message2 .= '<div style="text-align:center; width: 100%; font-size: 20px; line-height: 30px ">';
          $message2 .= '<p>';
          $message2 .= 'Dziekujęmy za rejestrację firmy ';
          $message2 .= $post->getCompany();
          $message2 .= ' na wydarzenie Offsight Poznań. Wkrótce się z Państwem skontaktujemy.';
          $message2 .= '</p>';
          $message2 .= '<p>';
          $message2 .= 'W przypadku pilnego kontaktu jesteśmy dostępni pod numerami telefonów:';
          $message2 .= '</p>';
          $message2 .= '<p>';
          $message2 .= '+48 795119439 - Wojciech Nowaczyk';
          $message2 .= '</p>';
          $message2 .= '<p>';
          $message2 .= '+48 500031769 - Jan Radomski';
          $message2 .= '</p>';
          $message2 .= '<p>';
          $message2 .= 'Pozdrawiamy';
          $message2 .= '</p>';
          $message2 .= '<p>';
          $message2 .= 'Zespół Offsight';
          $message2 .= '</p>';
          $message2 .= "</div>";
          $message2 .= "</body></html>";
          mail($to2, $subject2, $message2, $headers2);



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
                   ->setMethod('POST')
                   ->add('email','text',['label' => '1'])
                   ->add('name','text', ['label' => '1'])
                   ->add('message','text', ['label' => '1'])
                   ->add('save','submit', ['label' => 'Wyślij'])
                   ->getForm();



       $form->handleRequest($request);
           if ($form->isSubmitted()) {
           $post = $form->getData();
           $em = $this->getDoctrine()->getManager();
           $em->persist($post);
           $em->flush();
           $to3 = $post->getEmail();

           $subject3 = 'Offsight | Kontakt';

           $headers3 = "From: offsight@meetnight.pl\r\n";
           $headers3 .= "Reply-To: offsight@meetnight.pl\r\n";
           $headers3 .= "Content-Type: text/html";

           $message3 = '<html><body>';
           $message3 .= '<img src="http://offsight.meetnight.pl/img/header.png" alt="Offsight" />';
           $message3 .= '<div style="text-align:center; width: 100%; font-size: 20px; line-height: 30px ">';
           $message3 .= '<p>';
           $message3 .= 'Dziekujęmy za skontaktowanie się z nami.';
           $message3 .= '</p>';
           $message3 .= '<p>';
           $message3 .= 'Wkrótce odpowiemy na Twoją wiadomość.';
           $message3 .= '</p>';
           $message3 .= '<p>';
           $message3 .= 'Pozdrawiamy';
           $message3 .= '</p>';
           $message3 .= '<p>';
           $message3 .= 'Zespół Offsight';
           $message3 .= '</p>';
           $message3 .= "</div>";
           $message3 .= "</body></html>";
           mail($to3, $subject3, $message3, $headers3);

           $to4 = 'offsight@meetnight.pl';

           $subject4 = 'Offsight | Kontakt';

           $headers4 = "From: offsight@meetnight.pl\r\n";
           $headers4 .= "Reply-To: offsight@meetnight.pl\r\n";
           $headers4 .= "Content-Type: text/html";

           $message4 = '<html><body>';
           $message4 .= '<img src="http://offsight.meetnight.pl/img/header.png" alt="Offsight" />';
           $message4 .= '<div style="text-align:center; width: 100%; font-size: 20px; line-height: 30px ">';
           $message4 .= '<p>';
           $message4 .= 'Od:<br/>';
           $message4 .= $post->getName();
           $message4 .= '<br/>';
           $message4 .= $post->getEmail();
           $message4 .= '</p>';
           $message4 .= '<p>';
           $message4 .= $post->getMessage();
           $message4 .= '</p>';
           $message4 .= "</div>";
           $message4 .= "</body></html>";
           mail($to4, $subject4, $message4, $headers4);


           return $this->redirectToRoute('onas');
         }

      return $this->render('default/aboutus.html.twig', ['form' => $form->createView()]);
     }

     /**
      * @Route("/wroclaw", name="wroclaw")
      */
      public function wroclawPage(Request $request){
        return $this->render('default/wroclaw.html.twig', []);
      }

      /**
       * @Route("/lodz", name="lodz")
       */
       public function lodzPage(Request $request){
         return $this->render('default/lodz.html.twig', []);
       }
}
