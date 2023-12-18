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
        $apiExt =  $_ENV['API_EXTERNAL_URL'];


        $headers = [
            'api-token' => $token,

        ];
        $response = $httpClient->request("GET", $apiExt . "/products", ["headers" => $headers]);

        $data = $response->getContent();


        // convert into array and delete the product that exists more than one time
        $dataArray = $response->toArray();

        $items = [];
        $categoryNames = array_column($items, 'category_name');

        foreach ($dataArray as $item) {
            // Check if the category name is not in the $items array
            if (!in_array($item['category_name'], $categoryNames)) {
                $items[] = $item;
                $categoryNames[] = $item['category_name'];
            }
        }

//        dd($items);


        return $this->render('home/index.html.twig', [
            "items" => $items,
            "apiExt" => $apiExt
        ]);
    }
}
