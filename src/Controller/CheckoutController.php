<?php

namespace App\Controller;


use App\Form\PackageFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Uid\Uuid;

class CheckoutController extends AbstractController
{


    #[Route("checkout")]
    public function index(Request $request, HttpClientInterface $httpClient)
    {

        $id = $request->query->get('i');


        $apiExt = $_ENV['API_EXTERNAL_URL'];

        $token = $_ENV['TOKEN_API_FLASH'];


        $headers = [
            'api-token' => $token,

        ];

        $response = $httpClient->request("GET", $apiExt . "/products", ["headers" => $headers]);

        $dataArray = $response->toArray();

        $item = [];

        for ($i = 0; $i < count($dataArray); $i++) {
            if ($dataArray[$i]["id"] == $id) {

                $item = $dataArray[$i];

            }
        }

        if ($item) {

            $range = $item["qty_values"];
            $min = $max = null;

            if ($range != null) {
                $min = $range['min'];
                $max = $range['max'];
            }

            $form = $this->createForm(PackageFormType::class, null, [
                'min' => $min,
                'max' => $max,
                'categoryName' => $item["category_name"]
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $data = $form->getData();

                $quantity = $data['quantity'];
                $playerId = $data['id'];

                $namespace = Uuid::v4();
                $uuid = Uuid::v5($namespace, $item['category_name']);
                $orderNumber = $uuid->toRfc4122();


            };

            return $this->render("checkout/index.html.twig", [
                "item" => $item,
                "form" => $form->createView(),
                "range" => $range
            ]);


        } else {

            return new JsonResponse(["message" => "Error, product not found"], 404);
        }


    }
}
