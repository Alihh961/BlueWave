<?php

namespace App\Service;

use App\Entity\InscriptionVerificationCode;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EmailService
{

    public function __construct(
        private HttpClientInterface    $httpClient,
        private UserRepository         $userRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function sendVerificationEmailcode($userEmail, $userName): InscriptionVerificationCode
    {

        $baseUrl = $_ENV['PROJECT_URL'];

        $verificationCode = uniqid();
        $verificationUrl = $baseUrl . "/verify-email?vc=" . $verificationCode . "&e=" . $userEmail;


        $this->sendEmail(
            'BlueWave',
            'khadidja_du_73@outlook.fr',
            $userName,
            $userEmail,
            'Email Verification',
            "
                        <p> Hello <span style='font-weight: bolder'>$userName</span> ,Click in the button bellow to verify your account</p>
                        <a href=\"$verificationUrl\" style ='padding: 5px 10px;background-color: #1c7430;text-decoration: none;color:white;border-radius:5px;display:inline-block'>Click here </a>
                        "
        );



        $verificationEntity = new InscriptionVerificationCode();
        $verificationEntity->setVerificationCode($verificationCode);

        return $verificationEntity;


    }


    protected function sendEmail($fromName, $fromEmail, $toName, $toEmail, $subject, $htmlContent)
    {


        $response = $this->httpClient->request('POST', "https://api.brevo.com/v3/smtp/email", [
            'headers' => [
                'accept' => 'application/json',
                'api-key' => "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",
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
