<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\infoProtect;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\RegisterType;

class AdminController extends Controller
{
  /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
      // get the login error if there is one
    $error = $authUtils->getLastAuthenticationError();

    // last username entered by the user
    $lastUsername = $authUtils->getLastUsername();
    // $userListe = $this->getDoctrine()->getRepository(User::class)->findAll();
    return $this->render('admin/login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));

    }
  /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(AuthenticationUtils $authUtils,Request $request)
    {

      $user = $this->getUser();
      $date = date_create(date("Y-m-d H:i:s"));
      $date = new \Datetime();
      $em = $this->getDoctrine()->getManager();
      $user->setDateDeconnexion($date);
      $em->persist($user);
      $em->flush();
     session_destroy();
      return $this->redirectToRoute('login');
  }
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
       
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        //Submit
        if($form->isSubmitted() && $form->isValid()){
            $user = $form -> getData();
            $userTest = $this->getDoctrine()->getRepository(User::class)->findOneByIdentifiant($user->getIdentifiant());
            $check = false;
           
              if($user->getIdentifiant() == $userTest->getIdentifiant())
              {
                $check = true;
                $request->getSession()->getFlashBag()->add('info', "Le pseudo est déjà utilisé. Choisissez-en un autre !");
                return $this->redirectToRoute('register');
              }
            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            if($check == false)
            {
              $em = $this->getDoctrine()->getManager();
              $user->setActif(0);
              $em -> persist($user);
              $em->flush();
              $request->getSession()->getFlashBag()->add('info', "La demande à bien été effectuée, une réponse  vous seras communiqué par mail dans les plus bref délais");

                // Creation du transport
                $infoProtect = new InfoProtect();
                $infoProtect = $this->getDoctrine()->getRepository(infoProtect::class)->findOneById(1);
        $transport = (new \Swift_SmtpTransport('ssl0.ovh.net', 465, 'ssl'))
        ->setUsername($infoProtect->getEmail())
        ->setPassword($infoProtect->getIdentifiant())
        ;

        $mailer = new \Swift_Mailer($transport);

        // Creation du message
        $message = (new \Swift_Message('Alerte enregistrement'))
          ->setFrom(['noreply@nexus-creation.com' => 'Nexus Création'])
          // ->setTo(['valentin@nexus-creation.com' => 'Valentin'])
          ->setTo(['timothee.nitharum@gmail.com' => 'Timothée'])
        ->setBody('Un utilisateur a fait une demande de compte. Merci de vous rendre au lien ci-dessous afin de pouvoir approuver ou désapprouver cette demande.
        http://localhost:8070/my-project/public/index.php/user/approuve/')
        ;
        // Envoie du message
        $result = $mailer->send($message);
        return $this->redirectToRoute('login');
            }
             
            }
          
          return $this->render('admin/register.html.twig', array('form' =>$form->createView()));
        }
}
