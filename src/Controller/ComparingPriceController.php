<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComparingPriceController extends AbstractController
{
    #[Route('admin/comparing-price', name: 'app_comparing_price')]
    public function index(HttpClientInterface $httpClient): Response
    {

        $apiExt = $_ENV['API_EXTERNAL_URL'];
        $token = $_ENV['TOKEN_API_FLASH'];


            $response = $httpClient->request("GET" ,$apiExt . '/products' , [
                'headers' => [
                    "api-token" => $token
                ]
            ] );
            $data = json_decode($response->getContent());



        return $this->render('comparing_price/index.html.twig', [
            'controller_name' => 'ComparingPriceController',
        ]);
    }
}
