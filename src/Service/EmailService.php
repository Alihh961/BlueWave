<?php

namespace App\Service;

use App\Entity\InscriptionVerificationCode;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EmailService
{

    public function __construct(
        private HttpClientInterface    $httpClient,
        private UserRepository         $userRepository,
        private EntityManagerInterface $entityManager,
        private MailerInterface        $mailer
    )
    {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendVerificationEmailcode($userEmail, $userName): InscriptionVerificationCode
    {

        try{
            $baseUrl = $_ENV['PROJECT_URL'];
            $blueWaveEmail = $_ENV['BLUEWAVE_EMAIL'];

            $verificationCode = uniqid();
            $verificationUrl = $baseUrl . "/verify-email?vc=" . $verificationCode . "&e=" . $userEmail;


            $email = (new Email())
                ->from($blueWaveEmail)
                ->to($userEmail)
                ->subject("Verification Email")
//            ->text('This is a test email sent from Symfony using Brévo SMTP.')
                ->html("
                        <p> Hello <span style='font-weight: bolder'>$userName</span> ,Click in the button bellow to verify your account</p>
                        <a href=\"$verificationUrl\" style ='padding: 5px 10px;background-color: #1c7430;text-decoration: none;color:white;border-radius:5px;display:inline-block'>Click here </a>
                        ");

            $this->mailer->send($email);

        }

        catch(\Exception $e){
            throw new \Exception($e);
        }


        $verificationEntity = new InscriptionVerificationCode();
        $verificationEntity->setVerificationCode($verificationCode);

        return $verificationEntity;


    }


    protected function sendEmail($fromName, $fromEmail, $toName, $toEmail, $subject, $htmlContent)
    {

        $brevoApiKey = $_ENV['BREVO_API_KEY'];

        $response = $this->httpClient->request('POST', "https://api.brevo.com/v3/smtp/email", [
            'headers' => [
                'accept' => 'application/json',
                'api-key' => $brevoApiKey,
                'content-type' => 'application/json'
            ],
            'json' => [
                "sender" => [
                    'name' => $fromName,
                    'email' => $fromEmail
                ],
                "to" => [
                    [
                        'email' => $toEmail,
                        'name' => $toName
                    ],

                ],
                "subject" => $subject,
                "htmlContent" => $htmlContent
            ]
        ]);
    }


}
