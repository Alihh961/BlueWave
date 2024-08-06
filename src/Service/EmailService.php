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
use Symfony\Component\Routing\Annotation\Route;
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
        $baseUrl = $_ENV['PROJECT_URL'];

        $verificationCode = uniqid();
        $brevoApiKey = $_ENV['BREVO_API_KEY'];


        try {

            $verificationCode = uniqid();
            $verificationUrl = $baseUrl . "/verify-email?vc=" . $verificationCode . "&e=" . urlencode($userEmail);

            $response = $this->httpClient->request('POST', "https://api.brevo.com/v3/smtp/email", [
                'headers' => [
                    'accept' => 'application/json',
                    'api-key' => $brevoApiKey,
                    'content-type' => 'application/json'
                ],
                'json' => [
                    "sender" => [
                        'name' => 'Blue Wave Mobiles',
                        'email' => 'no-reply@bluewavemobiles.com'
                    ],
                    "to" => [
                        [
                            'email' => $userEmail,
                            'name' => $userName
                        ],
                    ],
                    "subject" => 'Verification email',
                    "htmlContent" => "
            <p>Hello <span style='font-weight: bolder'>$userName</span>, click the button below to verify your account</p>
            <a href=\"$verificationUrl\" style='padding: 5px 10px; background-color: #1c7430; text-decoration: none; color: white; border-radius: 5px; display: inline-block'>Click here</a>
        "
                ]
            ]);




        } catch (\Exception$e) {

            return $this->json($e->getMessage());
        }


        $verificationEntity = new InscriptionVerificationCode();
        $verificationEntity->setVerificationCode($verificationCode);

        return $verificationEntity;


    }

    #[Route("sendemail")]
    protected function sendEmail($fromName, $fromEmail, $toName, $toEmail, $subject, $htmlContent)
    {
        $baseUrl = $this->container->get('router')->getContext()->getBaseUrl();

        return $this->json($baseUrl);


        $brevoApiKey = $_ENV['BREVO_API_KEY'];

        $response = $this->httpClient->request('POST', "https://api.brevo.com/v3/smtp/email", [
            'headers' => [
                'accept' => 'application/json',
                'api-key' => $brevoApiKey,
                'content-type' => 'application/json'
            ],
            'json' => [
                "sender" => [
                    'name' => 'toto',
                    'email' => 'hajhassan.ali92@gmail.com'
                ],
                "to" => [
                    [
                        'email' => 'hajhassan.ali@outlook.com',
                        'name' => 'totorr'
                    ],

                ],
                "subject" => 'jkerkjghjklerhglkerhgerg',
                "htmlContent" => 'kjherkjghlkerhjglkmher'
            ]
        ]);

        return $this->json('success');
    }


}
