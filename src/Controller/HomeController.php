<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(HttpClientInterface $httpClient): Response
    {
        $token = $_ENV['TOKEN_API_FLASH'];


        $headers = [
            'api-token' => $token,

        ];
        $response = $httpClient->request("GET" ,"https://api.flashvision.co/client/api/products" , ["headers" => $headers]);

        $data = $response->getContent();

        $productsArray = $response->toArray();


        return $this->render('home/index.html.twig', [
            "products" => $productsArray
        ]);
    }
}
