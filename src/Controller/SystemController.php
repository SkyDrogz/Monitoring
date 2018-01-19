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
    public function index()
    {
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
    public function consultation(\Swift_Mailer $mailer)
    {
      // $command=null; 
      $name="ok";
      $systemListe = $this->getDoctrine()->getRepository(Systeme::class)->findAll();
      foreach($systemListe as $system){
      $command = exec('ping '.$system->getUrl()." -n 1");
      if (preg_match("#Minimum#",$command))
      {
        $system->setEtat('Online');
      }
      else
      {
        $system->setEtat('Offline');
      }
         // Création d'une nouvelle ressource cURL
        $curl = curl_init();

        // Configuration de l'URL et d'autres options
        curl_setopt_array($curl,array(
        CURLOPT_URL=> $system->getUrl(),
         CURLOPT_RETURNTRANSFER=>true,
        ));
        // Récupération de l'URL et affichage sur le navigateur
        curl_exec($curl);

        // Fermeture de la session cURL
        curl_close($curl);
       
        if ($curl=== true)
        {
          $system->setEtat('Online');
        }
        else
        {
          $system->setEtat('Offline');
        }

      
      // else
      // {
      //   $system->setEtat('Online');
      // }
        // if ($system->getEtat()=='Offline')
        // {
        //   $message = (new \Swift_Message('Alerte'.$system->getNom()."Est down!"))
        //   ->setFrom('noreply@nexus-creation.com')
        //   ->setTo('timothee.nitharum@gmail.com')
        //   ->setBody(
        //       $this->renderView(
        //           // templates/emails/registration.html.twig
        //           'emails/registration.html.twig',
        //           array('name' => $system->getNom())
        //       ),
        //       'text/html'
              
        //     );
        //     $mailer->send($message);
        // }
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
