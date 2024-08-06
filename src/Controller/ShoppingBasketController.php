<?php

namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderStatusHistory;
use App\Entity\Transaction;
use App\Repository\ItemRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Uid\Uuid;

class ShoppingBasketController extends AbstractController
{


    #[Route('/shopping-basket')]
    public function index()
    {

        return $this->render('basket/index.html.twig' , [
            'user' => $this->getUser()

        ]);

    }

    #[Route('/order-items', methods: ['POST'])]
    public function orderAccessory(Request                $request, ItemRepository $itemRepository, StatusRepository $statusRepository,
                                   EntityManagerInterface $entityManager)
    {


        $user = $this->getUser();
        $userBalance = $user->getCurrentBalance();


        $itemsData = json_decode($request->getContent(),true);


        $totalPrice = 0;
        $totalQuantity = 0; // number of total items in the order
        $items = [];
        $order = new Order();

        try {

            foreach ($itemsData as $index => $oneItem) {


                $item = $itemRepository->find($oneItem['id']);

                $quantity = $oneItem['quantity'];

                $totalQuantity += $quantity;

                $items[] = ['name'=> $item->getName() , 'quantity' => $oneItem['quantity']];

                for ($i = 0; $i < $quantity; $i++) {
                    $order->addItem($item);
                    $totalPrice += $item->getPrice();
                }


            }

            $itemsString = '';

            foreach ($items as $item){

                $itemsString .= $item['name'] . '}' . $item['quantity'] . '; ';
            }


        // convert dim array into string and store it in the item name then
            // fetch the items and its quantity in the order table



            $beirutTimeZone = new \DateTimeZone("Asia/Beirut");
            $dateTimeInBeirut = new \DateTime("now", $beirutTimeZone);

            $currentStatus = $statusRepository->findOneBy(['name' => 'pending']);

            $namespace = Uuid::v4();
            $uuid = Uuid::v5($namespace, 'blueWave');
            $orderNumber = $uuid->toRfc4122();

            $order->setOrderReference($orderNumber);
            $order->setPrice(0);
            $order->setTotalPrice($totalPrice);





            $order->setParamsEntered('');


            $order->setUser($user);
            $order->setCreatedAt($dateTimeInBeirut);

            $order->setItem($itemsString);

            $order->setQuantity($totalQuantity);


            $orderStatusHistory = new OrderStatusHistory();

            $orderStatusHistory->setOrder($order);
            $orderStatusHistory->setStatus($currentStatus);
            $orderStatusHistory->setStatusUpdateDate($dateTimeInBeirut);

            $order->addOrderStatusHistory($orderStatusHistory);

            $transaction = new Transaction();
            $transaction->setUser($user);
            $transaction->setTransactionDate($dateTimeInBeirut);
            $transaction->setAmount($totalPrice);
            $transaction->setIsCredit(false);

            $newBalance = $userBalance - $totalPrice;
            $user->setCurrentBalance($newBalance);


            if ($totalPrice > $userBalance) {
                return new JsonResponse([
                        'title' => 'Insufficient Funds',
                        'message' => 'You must recharge your account'],
                402
                );
            }


            $entityManager->persist($transaction);
            $entityManager->persist($order);
            $entityManager->flush();
            return new JsonResponse([
                'title' => 'Pending',
                'message'=> 'Your order has been placed! It will be treated soon.'

            ],
            200);

        } catch (\Exception $e) {
            return new JsonResponse($e->getMessage() , 500);
        }




    }

}
