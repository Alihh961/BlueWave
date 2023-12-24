<?php

namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderStatusHistory;
use App\Entity\Status;
use App\Form\PackageFormType;
use App\Repository\OrderStatusHistoryRepository;
use App\Repository\StatusRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Timezone;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Uid\Uuid;

class CheckoutController extends AbstractController
{


    #[Route("checkout")]
    public function index(Request $request, HttpClientInterface $httpClient ,
                          OrderStatusHistoryRepository $orderStatusHistoryRepository, StatusRepository $statusRepository)
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

                $item['price'] = $item['price'] * $min + 0.3;
                $item['price'] = $item['price'] / $min;
            } else {
                $item['price'] += 0.3;
            }

            $form = $this->createForm(PackageFormType::class, null, [
                'min' => $min,
                'max' => $max,
                'categoryName' => $item["category_name"],
                'unitPrice' => $item['price']
            ]);



            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $data = $form->getData();
                $productType = $item['product_type'];
                if ($productType == 'package') {
                    $quantity = 1;

                } else {
                    $quantity = $data['quantity'];

                }

                $playerId = $data['id'];
                $price = $item['price'];
                $productId = $item["id"];

                $user = $this->getUser();

                $beirutTimeZone = new \DateTimeZone("Asia/Beirut");
                $dateTimeInBeirut = new \DateTime("now",$beirutTimeZone);

                $currentStatus = $statusRepository->findOneBy(['name' =>'pending']);


                $namespace = Uuid::v4();
                $uuid = Uuid::v5($namespace, $item['category_name']);
                $orderNumber = $uuid->toRfc4122();

                $toto = [$quantity, $playerId, $orderNumber, $productId];

                $order = new Order();
                $order->setOrderReference($orderNumber);
                $order->setPrice($price);
                $order->setUser($user);
                $order->setCreatedAt($dateTimeInBeirut);

                $orderStatusHistory = new OrderStatusHistory();
                $orderStatusHistory->setOrder($order);
                $orderStatusHistory->setStatus($currentStatus);
                $orderStatusHistory->setStatusUpdateDate($dateTimeInBeirut);

                $order->addOrderStatusHistory($orderStatusHistory);

                dd($order);

                dd($toto);


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
