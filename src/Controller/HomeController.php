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
        $response = $httpClient->request("GET", "https://api.flashvision.co/client/api/products", ["headers" => $headers]);

        $data = $response->getContent();


        // convert into array and delete the product that exists more than one time
        $dataArray = $response->toArray();

        $categoryNames = [];

        foreach ($dataArray as $item){
            if(!in_array($item["category_name"],$categoryNames)){
                $categoryNames[] =$item["category_name"];
            }
        }

//        dd($categoryNames);



        return $this->render('home/index.html.twig', [
            "categoryNames" => $categoryNames
        ]);
    }
}
