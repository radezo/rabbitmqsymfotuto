<?php

namespace App\Controller;

use App\Entity\User;

use App\Form\UserType;
use App\Message\MailNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    protected $passwordEncoder;

    /**
     * RegistrationController constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            //set role
            $user->setRoles(['ROLE_USER']);

            //save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $this->dispatchMessage(new MailNotification("toto", 1, 'toto@gmail.com'));

            /*$email = (new Email())
                ->from('rauldelazota@gmail.com')
                ->to('test@gmail.com')
                ->subject('New incident test: xxxxxx')
                ->html('<p></p>');

            $mailer->send($email);*/

            //sleep(5);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
