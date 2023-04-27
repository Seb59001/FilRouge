<?php

namespace Acme\Demo\Mailer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Scheb\TwoFactorBundle\Mailer\AuthCodeMailerInterface;
use Scheb\TwoFactorBundle\Model\Email\TwoFactorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Address;


class MyAuthCodeMailer extends AbstractController  implements AuthCodeMailerInterface
{

    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;

    }

    #[Route('/mail', name: 'custom_mailer_service')]
    public function sendAuthCode(TwoFactorInterface $user): void
    {
        // Récupération du code d'authentification à partir de l'utilisateur
        $authCode = $user->getEmailAuthCode();
        $choosenUser = $this->getUser() ;

        // Personnalisation de l'e-mail
        $email = (new TemplatedEmail())
            ->from(new Address('no-reply@classroom.net', 'Class ROOM'))
            ->to($user->getEmailAuthRecipient())
            ->subject('Code d\'authentification')
            ->htmlTemplate('mails/authMail.html.twig')
            ->context([
                'userNom'=> $choosenUser->getNom(),
                'userPrenom'=> $choosenUser->getPrenom(),
                'code'=> $authCode
            ]);

        // Envoi de l'e-mail
        $this->mailer->send($email);
    }
}
