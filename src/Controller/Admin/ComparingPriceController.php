<?php

namespace App\Controller\Admin;

use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ComparingPriceController extends AbstractController
{
    #[Route('admin/comparing-price', name: 'app_comparing_price')]
    public function index(HttpClientInterface $httpClient, ItemRepository $visionItemRepository): Response
    {

        $apiExt = $_ENV['API_EXTERNAL_URL'];
        $token = $_ENV['TOKEN_API_FLASH'];


        $response = $httpClient->request("GET", $apiExt . '/products', [
            'headers' => [
                "api-token" => $token
            ]
        ]);
        $visionItems = json_decode($response->getContent(), true);

        $ourItems = $visionItemRepository->findAll();
        $ourItemsVisionId = [];


        // here we want to check if all ids of the api exist in our database, if no then there is new items
        // first we select the ids of vision item in our database then we check if all vision items exists(35->48);
        foreach ($ourItems as $item) {
            $ourItemsVisionId[] = $item->getVisionId();
        }

        $missedItems = [];
        $itemsOfDifferentPrices = [];

        foreach ($visionItems as $visionItem) {

            if (!in_array($visionItem['id'], $ourItemsVisionId)) {
                if($visionItem['product_type'] != 'specificPackage'){
                    $missedItems[] = $visionItem;

                }

            }

        }



        //here we want to check if there is a difference of price
        foreach ($ourItems as $item) {

            $itemPrice = $item->getPrice();
            $min = $item->getAttributes()->getMinAndMax()[0] ?? 1;

            if (is_array($min)) {
                $min = $min[0];
            }


            if ($itemPrice * $min >= 2.3) {

                $initialPrice = ($itemPrice * $min) - 0.3;
                $initialPrice /= $min;

            } else {
                $initialPrice = ($itemPrice * $min) - 0.1;
                $initialPrice /= $min;
                if ($item->getVisionId() == 189) {
                    $toto = $initialPrice;
                }

            }

            $visionId = $item->getVisionId();


            foreach ($visionItems as $visionItem) {

                if ($visionItem['id'] == $visionId) {

                    if (round($initialPrice, 2) != round($visionItem['price'], 2)) {
                        $itemsOfDifferentPrices[] = $visionItem;

                    }
                }
            }

            // we just modify the price to fetch it in twig
            $item->setPrice($initialPrice);

        }


        return $this->render('comparing_price/index.html.twig', [
            'itemsDiffPrice' => $itemsOfDifferentPrices,
            'missedItems' => $missedItems,
            'ourItems' => $ourItems
        ]);
    }


    /**
     * @throws \Exception
     */
    #[Route('admin/update-price', name: 'app_update_price')]
    public function updatePrice(Request $request, ItemRepository $visionItemRepository, EntityManagerInterface $entityManager)
    {

        $id = $request->query->get('id');
        $newPrice = $request->query->get('newPrice');

        $item = $visionItemRepository->find($id);
        $min = $item->getAttributes()->getMinAndMax()[0] ?? 1;


        if (is_array($min)) {
            $min = $min[0];
        }

        $newPrice *= $min;

        if ($newPrice >= 2) {
            $newPrice += 0.3;
        } else {
            $newPrice += 0.1;
        }
        $newPrice /= $min;

        $item->setPrice($newPrice);


        try{
            $entityManager->persist($item);
            $entityManager->flush();
            return $this->redirectToRoute('app_comparing_price');
        }

        catch(\Exception $exception){
            throw new \Exception($exception);
        }

    }
}
