<?php

namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderStatusHistory;
use App\Entity\Transaction;
use App\Repository\AccessoriesRepository;
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

        return $this->render('basket/index.html.twig');

    }

    #[Route('/order-accessories', methods: ['POST'])]
    public function orderAccessory(Request                $request, AccessoriesRepository $accessoriesRepository, StatusRepository $statusRepository,
                                   EntityManagerInterface $entityManager)
    {


        $user = $this->getUser();
        $userBalance = $user->getCurrentBalance();


        $itemsData = json_decode($request->getContent(),true);



        $totalPrice = 0;
        $totalQuantity = 0;
        $items = [];
        $order = new Order();
        try {

            foreach ($itemsData as $index => $item) {


                $accessory = $accessoriesRepository->find($item['id']);
                $quantity = $item['quantity'];
                $totalQuantity += $quantity;

                $items[] = ['id'=> $item['id'] , 'quantity' => $item['quantity']];

                for ($i = 0; $i < $quantity; $i++) {
                    $order->addAccessory($accessory);
                    $totalPrice += $accessory->getPrice();
                }


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


            $itemsString = implode('+' ,$items);
            $order->setParamsEntered($itemsString);

            $order->setUser($user);
            $order->setCreatedAt($dateTimeInBeirut);

            $order->setItem('Accessory');

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
                'message'=> 'Your order has been placed! It will be confirmed soon.'

            ],
            200);

        } catch (\Exception $e) {
            dd($e);
            return new JsonResponse(null, 400);
        }





        return $this->json([$ids]);
    }

}
