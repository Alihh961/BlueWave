<?php

namespace App\Controller;


use App\Entity\Category;
use App\Entity\Params;
use App\Entity\Item;
use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Contracts\HttpClient\HttpClientInterface;

//#[Route("test", name: "app_test")]
class TestController extends AbstractController
{

    public function __construct(
        private HttpClientInterface $httpClient,
    )
    {
    }

//    #[Route("/")]
//
//    public function sendEmail(MailerInterface $mailer)
//    {
//
//        try{
//            $email = (new Email())
//                ->from('hello@example.com')
//                ->to('hajhassan.ali@outlook.com')
//                //->cc('cc@example.com')
//                //->bcc('bcc@example.com')
//                //->replyTo('fabien@example.com')
//                //->priority(Email::PRIORITY_HIGH)
//                ->subject('Time for Symfony Mailer!')
//                ->text('Sending emails is fun again!')
//                ->html('<p>See Twig integration for better HTML integration!</p>');
//
//            $mailer->send($email);
//        }
//
//        catch(err){
//            return $this->json('error');
//        }
//
//
//        return new JsonResponse('success');
//
//
//    }


    #[Route("sendemail")]
    public function e()
    {
        $baseUrl = $_ENV['PROJECT_URL'];

        $userEmail = 'hajhassan.ali@outlook.com'; // Use a proper email format
        $userName = 'username';

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


            return $this->json('Email sent successfully.');


        } catch (\Exception$e) {

            return $this->json($e->getMessage());
        }


    }


    public function toto(ItemRepository $itemRepository, CategoryRepository $categoryRepository, EntityManagerInterface $entityManager)
    {
        $dataArray =
            [
                [
                    'id' => 28,
                    'name' => '60uc',
                    'price' => 0.87,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'pubg mobile global',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '3'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 49,
                    'name' => '252 currency',
                    'price' => 4.75,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'Bigo live',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 179,
                    'name' => '3 Months',
                    'price' => 7,
                    'params' => [
                        'email',
                        'password'
                    ],
                    'category_name' => 'Shahid VIP',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 47,
                    'name' => 'Likee live',
                    'price' => 0.019,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Likee live',
                    'qty_values' => [
                        'min' => '100',
                        'max' => '20000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 189,
                    'name' => '830 مجوهرة',
                    'price' => 1.85,
                    'params' => [
                        'playerId'],
                    'category_name' => 'yalla ludo diamonds',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 197,
                    'name' => '278 diamonds',
                    'price' => 4.7,
                    'params' => [
                        'playerId',
                        'server'
                    ],
                    'category_name' => 'mobile legends bang bang',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 338,
                    'name' => 'PSN  LEB  5$',
                    'price' => 5,
                    'params' => [],
                    'category_name' => 'PLAYSTATION LEB',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 29,
                    'name' => '325UC',
                    'price' => 4.3,
                    'params' => [
                        'playerId'],
                    'category_name' => 'pubg mobile global',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 181,
                    'name' => '1 year',
                    'price' => 21,
                    'params' => [
                        'email',
                        'password'
                    ],
                    'category_name' => 'Shahid VIP',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 60,
                    'name' => 'Yoho waka',
                    'price' => 0.001,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Yoho waka',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '200000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 333,
                    'name' => 'PSN  LEB 10$',
                    'price' => 9,
                    'params' => [],
                    'category_name' => 'PLAYSTATION LEB',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 190,
                    'name' => '2333 مجوهرة',
                    'price' => 4.83,
                    'params' => [
                        'playerId'],
                    'category_name' => 'yalla ludo diamonds',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 198,
                    'name' => 'diamonds 505+66',
                    'price' => 9.4,
                    'params' => [
                        'playerId',
                        'server'
                    ],
                    'category_name' => 'mobile legends bang bang',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 334,
                    'name' => 'PSN  LEB 20$',
                    'price' => 18,
                    'params' => [],
                    'category_name' => 'PLAYSTATION LEB',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 191,
                    'name' => '5200 مجوهرة',
                    'price' => 9.58,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'yalla ludo diamonds',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 199,
                    'name' => '1192 diamonds',
                    'price' => 18.8,
                    'params' => [
                        'playerId',
                        'server'
                    ],
                    'category_name' => 'mobile legends bang bang',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 79,
                    'name' => 'Popo chat',
                    'price' => 0.00010666666666666667,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Popo chat',
                    'qty_values' => [
                        'min' => '15000',
                        'max' => '2000000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 31,
                    'name' => '1800 UC',
                    'price' => 21.25,
                    'params' => [
                        'playerId'],
                    'category_name' => 'pubg mobile global',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 52,
                    'name' => '1009 currency',
                    'price' => 19,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Bigo live',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 335,
                    'name' => 'PSN  LEB  50$',
                    'price' => 46,
                    'params' => [],
                    'category_name' => 'PLAYSTATION LEB',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 192,
                    'name' => '13000 مجوهرة',
                    'price' => 23.99,
                    'params' => [
                        'playerId'],
                    'category_name' => 'yalla ludo diamonds',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 212,
                    'name' => '1788 diamonds',
                    'price' => 28.2,
                    'params' => [
                        'playerId',
                        'server'
                    ],
                    'category_name' => 'mobile legends bang bang',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 283,
                    'name' => 'Soulchill packages',
                    'price' => 0.0163,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'Soulchill packages',
                    'qty_values' => [
                        '100',
                        '200',
                        '300',
                        '400',
                        '400',
                        '500',
                        '1000',
                        '200',
                        '4000',
                        '5000',
                        '10000'
                    ],
                    'product_type' => 'specificPackage'
                ],
                [
                    'id' => 32,
                    'name' => '3850UC',
                    'price' => 42.5,
                    'params' => [
                        'playerId'],
                    'category_name' => 'pubg mobile global',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '3'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 336,
                    'name' => 'PSN  LEB  100$',
                    'price' => 90,
                    'params' => [],
                    'category_name' => 'PLAYSTATION LEB',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 193,
                    'name' => '27800 جوهرة',
                    'price' => 46,
                    'params' => [
                        'playerId'],
                    'category_name' => 'yalla ludo diamonds',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 201,
                    'name' => '3005 diamonds',
                    'price' => 47,
                    'params' => [
                        'playerId',
                        'server'
                    ],
                    'category_name' => 'mobile legends bang bang',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 293,
                    'name' => '1250 currency',
                    'price' => 19,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Bigo live',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 33,
                    'name' => '8100 UC',
                    'price' => 84,
                    'params' => [
                        'playerId'],
                    'category_name' => 'pubg mobile global',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '3'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 40,
                    'name' => 'Soul chil',
                    'price' => 0.0184,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Soul chil',
                    'qty_values' => [
                        'min' => '50',
                        'max' => '10000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 194,
                    'name' => '56000جوهرة',
                    'price' => 95.8,
                    'params' => [
                        'playerId'],
                    'category_name' => 'yalla ludo diamonds',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 211,
                    'name' => 'Diamonds 3606',
                    'price' => 56.4,
                    'params' => [
                        'playerId',
                        'server'
                    ],
                    'category_name' => 'mobile legends bang bang',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 80,
                    'name' => 'Bella chat',
                    'price' => 0.00093,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Bella chat',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 290,
                    'name' => '250 عملة',
                    'price' => 3.8,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'Bigo live',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 30,
                    'name' => '660 UC',
                    'price' => 8.5,
                    'params' => [
                        'playerId'],
                    'category_name' => 'pubg mobile global',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '2'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 51,
                    'name' => '504 currency',
                    'price' => 9.5,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Bigo live',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 61,
                    'name' => 'Ahlan chat',
                    'price' => 0.00039,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Ahlan chat',
                    'qty_values' => [
                        'min' => '2000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 34,
                    'name' => '16200 UC',
                    'price' => 168,
                    'params' => [
                        'playerId'],
                    'category_name' => 'pubg mobile global',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '3'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 57,
                    'name' => '2524 عملة',
                    'price' => 46,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Bigo live',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 203,
                    'name' => '4810 diamonds',
                    'price' => 75.2,
                    'params' => [],
                    'category_name' => 'mobile legends bang bang',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 382,
                    'name' => 'SOUL CHILL Crystal',
                    'price' => 0.00184,
                    'params' => [
                        'playerId'],
                    'category_name' => 'SOUL CHILL Crystal',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '500000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 58,
                    'name' => '5048 عملة',
                    'price' => 91,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Bigo live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 209,
                    'name' => '6012 diamonds',
                    'price' => 92,
                    'params' => [
                        'playerId',
                        'server'
                    ],
                    'category_name' => 'mobile legends bang bang',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 81,
                    'name' => 'Talktalk',
                    'price' => 0.00067,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Talktalk',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '500000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 82,
                    'name' => 'Binmo chat',
                    'price' => 0.0011142857142857144,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Binmo chat',
                    'qty_values' => [
                        'min' => '700',
                        'max' => '100000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 89,
                    'name' => 'Lama chat',
                    'price' => 0.00116,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Lama chat',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 90,
                    'name' => 'Hiya chat',
                    'price' => 0.00114,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Hiya chat',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 92,
                    'name' => 'Ligo live',
                    'price' => 0.0013,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Ligo live',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 318,
                    'name' => 'TikTok 17500coins',
                    'price' => 186,
                    'params' => [
                        'email',
                        'password',
                        'contactNumber'
                    ],
                    'category_name' => 'TikTok 17500coins',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 284,
                    'name' => 'TikTok',
                    'price' => 0.011000000000000001,
                    'params' => [
                        'email',
                        'password',
                        'contactnumber'
                    ],
                    'category_name' => 'TikTok',
                    'qty_values' => [
                        'min' => '350',
                        'max' => '1000000000000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 107,
                    'name' => 'Sango chat',
                    'price' => 0.0005,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Sango chat',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 93,
                    'name' => 'Lami chat',
                    'price' => 0.00058,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Lami chat',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 94,
                    'name' => 'Haki chat',
                    'price' => 0.00114,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Haki chat',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 95,
                    'name' => 'Light chat',
                    'price' => 0.0004,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Light chat',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 98,
                    'name' => 'Azal live',
                    'price' => 0.00084,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Azal live',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 99,
                    'name' => 'Aswat chat',
                    'price' => 0.0007066666666666667,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Aswat chat',
                    'qty_values' => [
                        'min' => '750',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 101,
                    'name' => 'POPPO LIVE',
                    'price' => 0.000106,
                    'params' => [
                        'playerId'],
                    'category_name' => 'POPPO LIVE',
                    'qty_values' => [
                        'min' => '15000',
                        'max' => '3000000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 102,
                    'name' => 'Hlah chat',
                    'price' => 0.00128,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Hlah chat',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 103,
                    'name' => 'Sun chat',
                    'price' => 0.0013,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Sun chat',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 104,
                    'name' => 'Hawa chat',
                    'price' => 0.000945,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Hawa chat',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 105,
                    'name' => 'Up live',
                    'price' => 0.0154,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Up live',
                    'qty_values' => [
                        'min' => '100',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 106,
                    'name' => 'Mr7ba chat',
                    'price' => 0.00029,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Mr7ba chat',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 108,
                    'name' => 'Party star',
                    'price' => 0.00109,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Party star',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 110,
                    'name' => 'Bobo chat',
                    'price' => 0.0011899999999999999,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Bobo chat',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 111,
                    'name' => 'Soulfa chat',
                    'price' => 0.0015400000000000001,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Soulfa chat',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 115,
                    'name' => 'Hayyakom chat',
                    'price' => 0.00078,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Hayyakom chat',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 116,
                    'name' => '4fun chat',
                    'price' => 0.00065,
                    'params' => [
                        'playerId'],
                    'category_name' => '4fun chat',
                    'qty_values' => [
                        'min' => '2000',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 118,
                    'name' => 'Lit chat',
                    'price' => 0.0019199999999999998,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Lit chat',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 196,
                    'name' => 'oohla chat',
                    'price' => 0.00076,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'oohla chat',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '200000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 213,
                    'name' => 'Mico',
                    'price' => 0.0069,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'Mico',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '20000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 220,
                    'name' => 'Habby live',
                    'price' => 0.00057,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Habby live',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '1000000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 282,
                    'name' => 'super live',
                    'price' => 0.00615,
                    'params' => [
                        'playerId'],
                    'category_name' => 'super live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 285,
                    'name' => 'DREAM CHAT',
                    'price' => 0.0013,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'DREAM CHAT',
                    'qty_values' => [
                        'min' => '900',
                        'max' => 5000
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 286,
                    'name' => 'SOUL U',
                    'price' => 0.0085,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'SOUL U',
                    'qty_values' => [
                        'min' => '100',
                        'max' => 5000
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 41,
                    'name' => 'FREE FIRE 100',
                    'price' => 0.95,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'free fire',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 287,
                    'name' => 'imo Live',
                    'price' => 0.02,
                    'params' => [
                        'phoneNumber'
                    ],
                    'category_name' => 'imo Live',
                    'qty_values' => [
                        '100',
                        '200',
                        '500',
                        '1000',
                        '2000'
                    ],
                    'product_type' => 'specificPackage'
                ],
                [
                    'id' => 42,
                    'name' => 'FREE FIRE 310+30',
                    'price' => 2.9,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'free fire',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 289,
                    'name' => 'SKY CHAT',
                    'price' => 0.0010555555555555555,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'SKY CHAT',
                    'qty_values' => [
                        'min' => '900',
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 43,
                    'name' => 'FREE FIRE 520 + 50',
                    'price' => 4.75,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'free fire',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 294,
                    'name' => 'DIDO CHAT',
                    'price' => 0.0014,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'DIDO CHAT',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '1000000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 44,
                    'name' => 'FREE FIRE 1060+106',
                    'price' => 9.5,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'free fire',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 295,
                    'name' => 'Fancy Live',
                    'price' => 8.8e-5,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Fancy Live',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '1000000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 45,
                    'name' => 'FREE FIRE 2180+218',
                    'price' => 18.6,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'free fire',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 296,
                    'name' => 'Kiyo Live',
                    'price' => 0.0005200000000000001,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Kiyo Live',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '200000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 297,
                    'name' => 'Sparty Chat',
                    'price' => 0.00107,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Sparty Chat',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '100000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 306,
                    'name' => 'Honye Jar',
                    'price' => 0.0083,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Honye Jar',
                    'qty_values' => [
                        'min' => '100',
                        'max' => '50000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 307,
                    'name' => 'Allo',
                    'price' => 0.00094,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Allo',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '500000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 308,
                    'name' => 'MIGO LIVE',
                    'price' => 0.00014000000000000001,
                    'params' => [
                        'playerId'],
                    'category_name' => 'MIGO LIVE',
                    'qty_values' => [
                        'min' => '5000',
                        'max' => '5000000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 327,
                    'name' => 'GOLD CHAT',
                    'price' => 0.0010500000000000002,
                    'params' => [
                        'playerId'],
                    'category_name' => 'GOLD CHAT',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '200000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 329,
                    'name' => 'YOBI LIVE',
                    'price' => 0.0011,
                    'params' => [
                        'playerId'],
                    'category_name' => 'YOBI LIVE',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 330,
                    'name' => 'TAKA LIVE',
                    'price' => 0.00011399999999999999,
                    'params' => [
                        'playerId'],
                    'category_name' => 'TAKA LIVE',
                    'qty_values' => [
                        'min' => '5000',
                        'max' => '1000000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 331,
                    'name' => 'TOP TOP',
                    'price' => 0.0011333333333333332,
                    'params' => [
                        'playerId'],
                    'category_name' => 'TOP TOP',
                    'qty_values' => [
                        'min' => '750',
                        'max' => '100000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 352,
                    'name' => 'SOUL CHAT',
                    'price' => 0.00093,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'SOUL CHAT',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '500000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 353,
                    'name' => 'KWAI-VIDEO',
                    'price' => 0.013500000000000002,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'KWAI-VIDEO',
                    'qty_values' => [
                        'min' => '200',
                        'max' => '10000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 356,
                    'name' => 'YoYO',
                    'price' => 0.000605,
                    'params' => [
                        'playerId'],
                    'category_name' => 'YoYO',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '500000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 359,
                    'name' => 'AYOME CHAT',
                    'price' => 0.00086,
                    'params' => [
                        'playerId'],
                    'category_name' => 'AYOME CHAT',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 362,
                    'name' => 'XENA LIVE',
                    'price' => 0.00011999999999999999,
                    'params' => [
                        'playerId'],
                    'category_name' => 'XENA LIVE',
                    'qty_values' => [
                        'min' => '5000',
                        'max' => '10000000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 62,
                    'name' => '## currency',
                    'price' => 1,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Yalla ludo Gold',
                    'qty_values' => [
                        'min' => '50000',
                        'max' => '5000000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 365,
                    'name' => 'TADA CHAT',
                    'price' => 0.0014,
                    'params' => [
                        'playerId'],
                    'category_name' => 'TADA CHAT',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '250000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 63,
                    'name' => '68500 currency',
                    'price' => 1.85,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Yalla ludo Gold',
                    'qty_values' => [
                        'min' => '1',
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 366,
                    'name' => 'HALLA CHAT',
                    'price' => 0.0009,
                    'params' => [
                        'playerId'],
                    'category_name' => 'HALLA CHAT',
                    'qty_values' => [
                        'min' => '500',
                        'max' => '300000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 64,
                    'name' => '224500 currency',
                    'price' => 4.65,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Yalla ludo Gold',
                    'qty_values' => [
                        'min' => '1',
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 368,
                    'name' => 'PEP LIVE',
                    'price' => 0.00083,
                    'params' => [
                        'playerId'],
                    'category_name' => 'PEP LIVE',
                    'qty_values' => [
                        'min' => '1000',
                        'max' => '500000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 65,
                    'name' => '1.48m  currency',
                    'price' => 9.22,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Yalla ludo Gold',
                    'qty_values' => [
                        'min' => '1',
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 369,
                    'name' => 'OLAMET',
                    'price' => 0.00018,
                    'params' => [
                        'playerId'],
                    'category_name' => 'OLAMET',
                    'qty_values' => [
                        'min' => '7000',
                        'max' => '1000000'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 66,
                    'name' => '3.7m currency',
                    'price' => 23,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Yalla ludo Gold',
                    'qty_values' => [
                        'min' => '1',
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 67,
                    'name' => '10.03m  currency',
                    'price' => 46,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Yalla ludo Gold',
                    'qty_values' => [
                        'min' => '1',
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 68,
                    'name' => '25.3m currency',
                    'price' => 92,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Yalla ludo Gold',
                    'qty_values' => [
                        'min' => '1',
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 69,
                    'name' => '## currency',
                    'price' => 1,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Meyo',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 70,
                    'name' => '85 currency',
                    'price' => 1.1,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Meyo',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 71,
                    'name' => '490 currency',
                    'price' => 5.2,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Meyo',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 72,
                    'name' => '980 currency',
                    'price' => 10.3,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Meyo',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 73,
                    'name' => '1960 currency',
                    'price' => 20.5,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Meyo',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 74,
                    'name' => '4900 currency',
                    'price' => 51,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Meyo',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 128,
                    'name' => '5000  Jawaker',
                    'price' => 0.65,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Jawaker',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 129,
                    'name' => '32.500 Jawaker',
                    'price' => 4,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Jawaker',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 130,
                    'name' => '70000 Jawaker',
                    'price' => 8.1,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Jawaker',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 131,
                    'name' => '150000 Jawaker',
                    'price' => 17.4,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Jawaker',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 132,
                    'name' => '230000 Jawaker',
                    'price' => 25.5,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Jawaker',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 133,
                    'name' => '400000 Jawaker',
                    'price' => 43.5,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Jawaker',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 134,
                    'name' => '825000 Jawaker',
                    'price' => 87,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Jawaker',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 141,
                    'name' => '## liveu',
                    'price' => 10,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Liveu',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 142,
                    'name' => '360 liveu',
                    'price' => 1.79,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Liveu',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 143,
                    'name' => '650 liveu',
                    'price' => 3,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Liveu',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 144,
                    'name' => '1250 liveu',
                    'price' => 5.69,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Liveu',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 145,
                    'name' => '2500 liveu',
                    'price' => 10.64,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Liveu',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 146,
                    'name' => '5000 liveu',
                    'price' => 19.65,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Liveu',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 147,
                    'name' => '## Tumile',
                    'price' => 10,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Tumile live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 148,
                    'name' => '360 Tumile',
                    'price' => 1.79,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Tumile live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 149,
                    'name' => '650 Tumile',
                    'price' => 3,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Tumile live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 150,
                    'name' => '1250 Tumile',
                    'price' => 5.69,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Tumile live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 151,
                    'name' => '2500 Tumile',
                    'price' => 10.64,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Tumile live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 152,
                    'name' => '5000 Tumile',
                    'price' => 19.65,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Tumile live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 154,
                    'name' => '5 American iTunes',
                    'price' => 4.65,
                    'params' => [],
                    'category_name' => 'I T U N E S',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 155,
                    'name' => '10 American iTunes',
                    'price' => 9.3,
                    'params' => [],
                    'category_name' => 'I T U N E S',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 156,
                    'name' => '15 American iTunes',
                    'price' => 13.95,
                    'params' => [],
                    'category_name' => 'I T U N E S',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 157,
                    'name' => '20 American iTunes',
                    'price' => 18.6,
                    'params' => [],
                    'category_name' => 'I T U N E S',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 158,
                    'name' => '25 American iTunes',
                    'price' => 23.25,
                    'params' => [],
                    'category_name' => 'I T U N E S',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 159,
                    'name' => '50 American iTunes',
                    'price' => 46.5,
                    'params' => [],
                    'category_name' => 'I T U N E S',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 164,
                    'name' => '1 user for a month',
                    'price' => 10,
                    'params' => [],
                    'category_name' => 'Netflix',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '100'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 165,
                    'name' => '3 months full account',
                    'price' => 4.07,
                    'params' => [],
                    'category_name' => 'Netflix',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 168,
                    'name' => '## azar diamond',
                    'price' => 10,
                    'params' => [],
                    'category_name' => 'Azar live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 169,
                    'name' => '440 azar diamond',
                    'price' => 3.31,
                    'params' => [],
                    'category_name' => 'Azar live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 170,
                    'name' => '902 azar diamond',
                    'price' => 6.51,
                    'params' => [],
                    'category_name' => 'Azar live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 171,
                    'name' => '1870 azar diamond',
                    'price' => 13.52,
                    'params' => [],
                    'category_name' => 'Azar live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 172,
                    'name' => '4950 azar diamond',
                    'price' => 31.86,
                    'params' => [],
                    'category_name' => 'Azar live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 173,
                    'name' => '11000 azar diamond',
                    'price' => 66.84,
                    'params' => [],
                    'category_name' => 'Azar live',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 174,
                    'name' => '## TL Steam Turkish',
                    'price' => 10,
                    'params' => [],
                    'category_name' => 'Steam card',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 175,
                    'name' => '20 TL Steam Turkish',
                    'price' => 1.06,
                    'params' => [],
                    'category_name' => 'Steam card',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 176,
                    'name' => '50 TL Steam Turkish',
                    'price' => 2.61,
                    'params' => [],
                    'category_name' => 'Steam card',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 177,
                    'name' => '100 TL Steam Turkish',
                    'price' => 5.22,
                    'params' => [],
                    'category_name' => 'Steam card',
                    'qty_values' => [
                        'min' => 1,
                        'max' => '10'
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 228,
                    'name' => '50 points',
                    'price' => 0.43,
                    'params' => [
                        'playerId'],
                    'category_name' => 'FiFa mobile',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 231,
                    'name' => '100 points',
                    'price' => 0.86,
                    'params' => [
                        'playerId'],
                    'category_name' => 'FiFa mobile',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 232,
                    'name' => '150 points',
                    'price' => 1.23,
                    'params' => [
                        'playerId'],
                    'category_name' => 'FiFa mobile',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 233,
                    'name' => '500 points',
                    'price' => 3.7,
                    'params' => [
                        'playerId'],
                    'category_name' => 'FiFa mobile',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 234,
                    'name' => '1050 points',
                    'price' => 7.3,
                    'params' => [
                        'playerId'],
                    'category_name' => 'FiFa mobile',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 235,
                    'name' => 'Gold pass',
                    'price' => 6.16,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Clash of Clans',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 236,
                    'name' => 'Pocketful of Gems (80 +8)',
                    'price' => 0.88,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Clash of Clans',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 237,
                    'name' => 'Pile of Gems (500 + 50)',
                    'price' => 4.4,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Clash of Clans',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 238,
                    'name' => 'Bag of Gems (1200 + 120)',
                    'price' => 8.8,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Clash of Clans',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 239,
                    'name' => 'Sack of Gems (2500 + 250)',
                    'price' => 17.6,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Clash of Clans',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 240,
                    'name' => 'Box of Gems (6500 + 650)',
                    'price' => 44,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Clash of Clans',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 241,
                    'name' => 'Chest of Gems (14000 + 1400)',
                    'price' => 88,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Clash of Clans',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 242,
                    'name' => 'Fistful of Gems (80 +8)',
                    'price' => 0.88,
                    'params' => [
                        'playerId'],
                    'category_name' => 'CLASH ROYALE',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 243,
                    'name' => 'Pouch of Gems (500 + 50)',
                    'price' => 4.4,
                    'params' => [
                        'playerId'],
                    'category_name' => 'CLASH ROYALE',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 244,
                    'name' => 'Bucket of Gems (1200 + 120)',
                    'price' => 8.8,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'CLASH ROYALE',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 253,
                    'name' => 'Farm Pass',
                    'price' => 4.4,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Hay Day',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 254,
                    'name' => 'Pile of Diamonds (50 +5)',
                    'price' => 1.76,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Hay Day',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 255,
                    'name' => 'Bag of Diamonds (130 + 13)',
                    'price' => 4.4,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Hay Day',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 256,
                    'name' => 'Sack of Diamonds (275 + 28)',
                    'price' => 8.8,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Hay Day',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 257,
                    'name' => 'Box of Diamonds (570 + 57)',
                    'price' => 17.6,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Hay Day',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 258,
                    'name' => 'Chest of Diamonds (1500 + 150)',
                    'price' => 35.2,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Hay Day',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 259,
                    'name' => 'Trunk of Diamonds (4000 + 400)',
                    'price' => 88,
                    'params' => [
                        'playerTag'
                    ],
                    'category_name' => 'Hay Day',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 269,
                    'name' => 'Barrel of Gems (2500 + 250)',
                    'price' => 17.6,
                    'params' => [],
                    'category_name' => 'CLASH ROYALE',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 270,
                    'name' => 'Wagon of Gems (6500 + 650)',
                    'price' => 44,
                    'params' => [
                        'playerId'],
                    'category_name' => 'CLASH ROYALE',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 271,
                    'name' => 'Mountain of Gems (14000 +1400)',
                    'price' => 88,
                    'params' => [
                        'playerId'],
                    'category_name' => 'CLASH ROYALE',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 272,
                    'name' => 'Clash Royale Gold Pass',
                    'price' => 5.28,
                    'params' => [
                        'playerId'],
                    'category_name' => 'CLASH ROYALE',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 273,
                    'name' => 'Clash Royale Diamond Pass',
                    'price' => 10.56,
                    'params' => [
                        'playerId'],
                    'category_name' => 'CLASH ROYALE',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 274,
                    'name' => 'Brawl Pass',
                    'price' => 8.8,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Brawl Stars',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 275,
                    'name' => '30 + 3 Gems',
                    'price' => 1.76,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Brawl Stars',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 276,
                    'name' => '80 + 8 Gems',
                    'price' => 4.4,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Brawl Stars',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 277,
                    'name' => '170 + 17 Gems',
                    'price' => 8.8,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Brawl Stars',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 278,
                    'name' => '360 + 36 Gems',
                    'price' => 17.6,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Brawl Stars',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 279,
                    'name' => '950 + 95 Gems',
                    'price' => 44,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Brawl Stars',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 280,
                    'name' => '2000 + 200 Gems',
                    'price' => 88,
                    'params' => [
                        'playerId'],
                    'category_name' => 'Brawl Stars',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 299,
                    'name' => '60CP',
                    'price' => 0.85,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Arena Breakout',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 300,
                    'name' => '310CP',
                    'price' => 4.25,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Arena Breakout',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 301,
                    'name' => '630CP',
                    'price' => 8.5,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Arena Breakout',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 302,
                    'name' => '1580CP',
                    'price' => 21.25,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Arena Breakout',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 303,
                    'name' => '3200CP',
                    'price' => 42.5,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Arena Breakout',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 304,
                    'name' => '6500CP',
                    'price' => 85,
                    'params' => [
                        'playerId',
                    ],
                    'category_name' => 'Arena Breakout',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 309,
                    'name' => '60 Genesis Crystal',
                    'price' => 0.85,
                    'params' => [
                        'playerId',
                        'selectServer'
                    ],
                    'category_name' => 'Genshin Impact',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 312,
                    'name' => '300 + 30 Genesis Crystal',
                    'price' => 4.3,
                    'params' => [
                        'playerId',
                        'selectServer'
                    ],
                    'category_name' => 'Genshin Impact',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 313,
                    'name' => '980 + 110 Genesis Crystal',
                    'price' => 13,
                    'params' => [
                        'playerId',
                        'selectServer'
                    ],
                    'category_name' => 'Genshin Impact',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 314,
                    'name' => '1980 + 260 Genesis Crystal',
                    'price' => 25.8,
                    'params' => [
                        'playerId',
                        'selectServer'
                    ],
                    'category_name' => 'Genshin Impact',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 315,
                    'name' => '3280 + 600 Genesis Crystal',
                    'price' => 42.15,
                    'params' => [
                        'playerId',
                        'selectServer'
                    ],
                    'category_name' => 'Genshin Impact',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 316,
                    'name' => '6480 + 1600 Genesis Crystal',
                    'price' => 85,
                    'params' => [
                        'playerId',
                        'selectServer'
                    ],
                    'category_name' => 'Genshin Impact',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 317,
                    'name' => 'empty moon blessing',
                    'price' => 4.3,
                    'params' => [
                        'playerId',
                        'selectServer'
                    ],
                    'category_name' => 'Genshin Impact',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 319,
                    'name' => '60uc',
                    'price' => 0.87,
                    'params' => [],
                    'category_name' => 'Pubg mobile code',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 320,
                    'name' => '325uc',
                    'price' => 4.3,
                    'params' => [],
                    'category_name' => 'Pubg mobile code',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 321,
                    'name' => '660uc',
                    'price' => 8.5,
                    'params' => [],
                    'category_name' => 'Pubg mobile code',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'package'
                ],
                [
                    'id' => 322,
                    'name' => '1800uc',
                    'price' => 21.25,
                    'params' => [],
                    'category_name' => 'Pubg mobile code',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 323,
                    'name' => '3850uc',
                    'price' => 42.25,
                    'params' => [],
                    'category_name' => 'Pubg mobile code',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 325,
                    'name' => '8100uc',
                    'price' => 84,
                    'params' => [],
                    'category_name' => 'Pubg mobile code',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 332,
                    'name' => '100 American iTunes',
                    'price' => 93,
                    'params' => [],
                    'category_name' => 'I T U N E S',
                    'qty_values' => null,
                    'product_type' => 'package'
                ],
                [
                    'id' => 339,
                    'name' => 'PSN  USA 5$',
                    'price' => 4.6,
                    'params' => [],
                    'category_name' => 'PLAYSTATION USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 340,
                    'name' => 'PSN  USA 10$',
                    'price' => 9.2,
                    'params' => [],
                    'category_name' => 'PLAYSTATION USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 341,
                    'name' => 'PSN  USA 25$',
                    'price' => 23,
                    'params' => [],
                    'category_name' => 'PLAYSTATION USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 342,
                    'name' => 'PSN  USA 50$',
                    'price' => 46,
                    'params' => [],
                    'category_name' => 'PLAYSTATION USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 343,
                    'name' => 'PSN  USA 75$',
                    'price' => 69,
                    'params' => [],
                    'category_name' => 'PLAYSTATION USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 344,
                    'name' => 'PSN  USA 75$',
                    'price' => 69,
                    'params' => [],
                    'category_name' => 'PLAYSTATION USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 345,
                    'name' => 'PSN  USA 100$',
                    'price' => 92,
                    'params' => [],
                    'category_name' => 'PLAYSTATION USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 346,
                    'name' => 'PSN UAE 5$',
                    'price' => 4.5,
                    'params' => [],
                    'category_name' => 'PLAYSTATION UAE',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 347,
                    'name' => 'PSN UAE  10$',
                    'price' => 9.2,
                    'params' => [],
                    'category_name' => 'PLAYSTATION UAE',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 348,
                    'name' => 'PSN UAE  20$',
                    'price' => 18,
                    'params' => [],
                    'category_name' => 'PLAYSTATION UAE',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 349,
                    'name' => 'PSN UAE  50$',
                    'price' => 45,
                    'params' => [],
                    'category_name' => 'PLAYSTATION UAE',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 350,
                    'name' => 'PSN UAE  100$',
                    'price' => 90,
                    'params' => [],
                    'category_name' => 'PLAYSTATION UAE',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 351,
                    'name' => 'PSN UAE  100$',
                    'price' => 90,
                    'params' => [],
                    'category_name' => 'PLAYSTATION UAE',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 355,
                    'name' => '100 --> 100k',
                    'price' => 0.000117,
                    'params' => [
                        'playerId'
                    ],
                    'category_name' => 'Jawaker',
                    'qty_values' => [
                        'min' => '100',
                        'max' => '100000'
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 358,
                    'name' => 'ITUNES 200$',
                    'price' => 186,
                    'params' => [],
                    'category_name' => 'I T U N E S',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 371,
                    'name' => '10 TR',
                    'price' => 10,
                    'params' => [],
                    'category_name' => 'STEAM TR',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 372,
                    'name' => '20 TR',
                    'price' => 10,
                    'params' => [],
                    'category_name' => 'STEAM TR',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 373,
                    'name' => '40 TR',
                    'price' => 40,
                    'params' => [],
                    'category_name' => 'STEAM TR',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 374,
                    'name' => '50 TR',
                    'price' => 50,
                    'params' => [],
                    'category_name' => 'STEAM TR',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 375,
                    'name' => 'ROBLOX 10$',
                    'price' => 10,
                    'params' => [],
                    'category_name' => 'ROBLOX USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 376,
                    'name' => 'ROBLOX 25$',
                    'price' => 25,
                    'params' => [],
                    'category_name' => 'ROBLOX USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 377,
                    'name' => 'ROBLOX 50$',
                    'price' => 50,
                    'params' => [],
                    'category_name' => 'ROBLOX USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 378,
                    'name' => 'ROBLOX 100$',
                    'price' => 100,
                    'params' => [],
                    'category_name' => 'ROBLOX USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 379,
                    'name' => '10$ USD',
                    'price' => 10,
                    'params' => [],
                    'category_name' => 'STEAM USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 380,
                    'name' => '20$ USD',
                    'price' => 19.5,
                    'params' => [],
                    'category_name' => 'STEAM USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ],
                [
                    'id' => 381,
                    'name' => '50$ USD',
                    'price' => 50,
                    'params' => [],
                    'category_name' => 'STEAM USA',
                    'qty_values' => [
                        'min' => 1,
                        'max' => 5000
                    ],
                    'product_type' => 'amount'
                ]
            ];


        $newArraydata = [];
        $categories = [];
        foreach ($dataArray as $data) {
            $item = new Item();

            $itemName = $data['name'];

            $availablility = true;

            $category = $data['category_name'];
            $categoryEntity = $categoryRepository->findOneBy(['name' => $category]);

            $itemTypeEntity = $itemRepository->findOneBy(['name' => $data['product_type']]);

            $paramsEntity = new Params();
            $params = $data['params'];


            $price = $data['price'];
            $min = $data['qty_values']['min'];

            if ($min) {
                if ($price < 2) {

                    $newPrice = ($min * $price) + 0.1;
                    $newPrice = $newPrice / $min;

                } else if ($price >= 2) {
                    $newPrice = ($min * $price) + 0.3;
                    $newPrice = $newPrice / $min;
                }
            } else {
                if ($price < 2) {

                    $newPrice = $price + 0.1;

                } else if ($price >= 2) {
                    $newPrice = $price + 0.3;
                }
            }

            $data['price'] = $newPrice;


        }


    }
}
