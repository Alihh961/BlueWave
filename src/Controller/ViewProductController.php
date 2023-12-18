<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ViewProductController extends AbstractController
{

    #[Route('view-product')]
    public function index(Request $request, HttpClientInterface $httpClient)
    {

        $categoryName = $request->query->get('c');

        $apiExt = $_ENV['API_EXTERNAL_URL'];
        $token = $_ENV['TOKEN_API_FLASH'];


        $headers = [
            'api-token' => $token,

        ];

        $response = $httpClient->request("GET", $apiExt . "/products", ["headers" => $headers]);



        // convert into array and delete the product that exists more than one time
        $dataArray = $response->toArray();

        $items = [];

        foreach ($dataArray as $item) {
            if ($item["category_name"] == $categoryName) {
                $items[] = $item;
            }
        }
//        dd($items);

        return $this->render("view-products/index.html.twig", [
            "items" => $items
        ]);


    }
}


