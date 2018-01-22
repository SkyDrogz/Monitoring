<?php

namespace App\Controller;

use App\Entity\Systeme;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\SystemType;

class SystemController extends Controller
{
  /**
  * @Route("/", name="index")
  */
  public function indexAccueil()
  {
    // exit;
    // replace this line with your own code!
    return $this->render('base.html.twig');
  }
  /**
  * @Route("/system", name="system")
  */
  public function index(\Swift_Mailer $mailer)
  {
    // Récupération du service
        $mailer = $this->get('mailer');

        // Création de l'e-mail : le service mailer utilise SwiftMailer, donc nous créons une instance de Swift_Message
        $message = (new \Swift_Message('Hello Email'))
          ->setSubject('Email ALERTE')
          ->setFrom('noreply@nexus-creation.com')
          ->setTo('baptiste.rossignol@hotmail.fr')
          ->setBody('Coucou, voici un email que vous venez de recevoir !');

        // Retour au service mailer, nous utilisons sa méthode « send() » pour envoyer notre $message
        $mailer->send($message);

        // N'oublions pas de retourner une réponse, par exemple une page qui afficherait « L'e-mail a bien été envoyé »
        return new Response('Email bien envoyé');
    // exit;
    // replace this line with your own code!
    return $this->render('system/index.html.twig');
  }

  /**
  * @Route("/system/new", name="system_new")
  */
  public function new(Request $request)
  {
    // Création du formulaire d'ajout d'un système
    $systeme = new Systeme();
    $form = $this->createForm(SystemType::class, $systeme);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $systeme = $form->getData();
      $em = $this->getDoctrine()->getManager();
      $em->persist($systeme);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Le système à bien été rajouté.");
      return $this->redirectToRoute('system_new');
    }

    return $this->render('system/new.html.twig', array('form' => $form->createView()));
  }


  /**
  * @Route("/system/edit/{id}", name="system_edit")
  */
  public function edit(Request $request, $id)
  {
    // Création du formulaire d'édition d'un système
    $em = $this->getDoctrine()->getManager();
    $systeme = $em->getRepository(Systeme::class)->find($id);

    if ($systeme) {
      $form = $this->createForm(SystemType::class, $systeme);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
        $systeme = $form -> getData();
        $em = $this->getDoctrine()->getManager();
        $em -> persist($systeme);
        $em->flush();
        return $this->redirectToRoute('system');
      }
      return $this->render('system/edit.html.twig', array('form' =>$form->createView()));
    }
    else {
      return $this->redirectToRoute('system');
    }


  }
    /**
     * @Route("/system/consultation", name="system_consultation")
     */
    public function consultation(Request $request)
    {
      // $command=null;
      $systemListe = $this->getDoctrine()->getRepository(Systeme::class)->findAll();
      foreach($systemListe as $system){
        if($system->getActif()== 1){
        if($system->getCategSysteme()->getCategorie() == "Serveur"){
        $command = exec('ping '.$system->getUrl()." -n 1");
        if (preg_match("#Minimum#",$command))
        {
          $system->setEtat('Online');
        }
        else
        {
          $system->setEtat('Offline');
        }
      }elseif($system->getCategSysteme()->getCategorie() == "Site internet"){
         // Création d'une nouvelle ressource cURL
         $curl = curl_init();

         curl_setopt_array($curl, array(
           CURLOPT_URL => $system->getUrl(),
           CURLOPT_RETURNTRANSFER => true,
         ));
        // Récupération de l'URL et affichage sur le navigateur
        $str =curl_exec($curl);

          if ($str === false)
        {
          $system->setEtat('Offline');
        }
        else
        {
          $system->setEtat('Online');
        }

        // Fermeture de la session cURL
        curl_close($curl);
      }elseif($system->getCategSysteme()->getCategorie() == "API"){
          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_PORT => "9200",
            CURLOPT_URL => $system->getUrl(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $system->getRequete(),
            CURLOPT_HTTPHEADER => array(
              "Cache-Control: no-cache",
              "Content-Type: application/json",
              "Postman-Token: a9414de1-6e95-fbc7-9c3c-94983fa42efb"
            ),
          ));
          if(curl_exec($curl) === false)
          {
            curl_close($curl);
            $system->setEtat("Offline (Serveur)");

          }
          else
          {
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            //Test résultat attendu
            if(preg_match("#".$system->getResultatAttendu()."#",$response))
            {
              //Test requete JSON
              if (preg_match("#error#",$response)) {
                $system->setEtat('Offline (Requête JSON incorrecte)');
              } else {
                $system->setEtat('Online');
              }
            }
            else {

              $system->setEtat('Offline (Résultat attendu introuvable)');
            }
            
          }

        }

      }

      $today = new \Datetime();
      $diff=$system->getDateOffline()->diff($today);
      if($system->getEtat()=="Offline" && $diff->i>=$system->getRepetition()){
        // $date = date_create(date("Y-m-d H:i:s"));
        $date = new \Datetime();
         $system->setDateOffline($date);
         $curl = curl_init();

         curl_setopt_array($curl, array(
           CURLOPT_URL => "http://www.isendpro.com/cgi-bin/?keyid=c3587be4e16f636a220c3ca07619911e&sms=".urlencode($system->getCategSysteme()->getCategorie()." ".$system->getNom()." est Offline")."&num=0613710486",
           CURLOPT_RETURNTRANSFER => true,
         ));
        curl_exec($curl);

  
      }
      $em = $this->getDoctrine()->getManager();
      $em->persist($system);
      $em->flush();
    }

      return $this->render('system/consultation.html.twig', array(
        'systemListe' => $systemListe
      ));
      return new Response($system);
  }



  /**
  * @Route("/system/suppression/{id}", name="system_suppression")
  */
  public function suppressionAction(Request $request,Systeme $systeme)
  {
    $em = $this->getDoctrine()->getManager();
    $systeme->setActif(false);
    $em->persist($systeme);
    $em->flush();

    return $this->redirectToRoute('system_consultation');

  }
  /**
  * @Route("/system/active", name="system_active")
  */
  public function active()
  {
    $systemListe = $this->getDoctrine()->getRepository(Systeme::class)->findAll();
    return $this->render('system/reactivation.html.twig', array(
      'systemListe' => $systemListe
    ));

    return new Response($system);
  }
  /**
  * @Route("/system/reactive/{id}", name="system_reactive")
  */
  public function activeAction(Request $request,Systeme $systeme)
  {
    $em = $this->getDoctrine()->getManager();
    $systeme->setActif(true);
    $em->persist($systeme);
    $em->flush();

    return $this->redirectToRoute('system_active');
  }






}
