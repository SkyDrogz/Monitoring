<?php

namespace App\Controller;

use App\Entity\InfoProtect;
use App\Entity\User;
use App\Form\RegisterType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $authUtils)
    {
        // On obtiens l'erreur de connexion s'il y en as une
        $error = $authUtils->getLastAuthenticationError();

        // Récupère le dernier identifiant entré par l'utilisateur s'il y en as un
        $lastUsername = $authUtils->getLastUsername();
        // Affichage de la page login
        return $this->render('admin/login.html.twig', array(
            'last_username' => $lastUsername,
            'error' => $error,
        ));

    }
    /**
     * @Route("/deconnexion", name="deconnexion")
     */
    public function deconnexion(AuthenticationUtils $authUtils, Request $request)
    {
      // Si la connexion est vide = redirection à la page login
        if (empty($_SESSION)) {
            return $this->redirectToRoute('login');
      // Si la session n'est pas vide, création d'une date de déconnexion + session détruite
        } else {
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
    }
    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        // Récupèration du formulaire dans RegisterType
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        //Si le formulaire est validé...
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $userTest = $this->getDoctrine()->getRepository(User::class)->findOneByIdentifiant($user->getIdentifiant());
            $check = false;
            // Vérification si l'identifiant n'est pas déjà utilisé
            if ($user->getIdentifiant() == $userTest) {
                $check = true;
                $request->getSession()->getFlashBag()->add('info', "Le pseudo est déjà utilisé. Choisissez-en un autre !");
                return $this->redirectToRoute('register');
            }
            //Récupèration du mot de passe clair + cryptage du mot de passe
            $plainPassword = $user->getPassword();
            $encoded = $encoder->encodePassword($user, $plainPassword);
            $user->setPassword($encoded);

            // Si l'identifiant n'est pas utilisé, nous le mettons dans la BDD en non-actif
            if ($check == false) {
                $em = $this->getDoctrine()->getManager();
                $user->setActif(0);
                $em->persist($user);
                $em->flush();
                // Affichage d'un flashbag annoncant la confirmation de la demande d'inscription
                $request->getSession()->getFlashBag()->add('msg', "La demande à bien été effectuée, une réponse  vous seras communiqué par mail dans les plus bref délais");

                // Creation du transport
                $infoProtect = new InfoProtect();
                $infoProtect = $this->getDoctrine()->getRepository(InfoProtect::class)->findOneById(1);
                $transport = (new \Swift_SmtpTransport('ssl0.ovh.net', 465, 'ssl'))
                    ->setUsername($infoProtect->getEmail())
                    ->setPassword($infoProtect->getIdentifiant())
                ;

                $mailer = new \Swift_Mailer($transport);

                // Creation du mail de message d'alerte
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
        //Redirection à la page register avec un flashbag annoncant si oui ou non la demande à été effectuée
        return $this->render('admin/register.html.twig', array('form' => $form->createView()));
    }
}
