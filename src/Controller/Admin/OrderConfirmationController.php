<?php

namespace App\Controller\Admin;

use App\Entity\Order;
use App\Entity\OrderStatusHistory;
use App\Entity\Transaction;
use App\Repository\OrderRepository;
use App\Repository\OrderStatusHistoryRepository;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Middleware\TraceableMiddleware;
use Symfony\Component\Routing\Annotation\Route;


class OrderConfirmationController extends AbstractController
{
    #[Route('admin/orders-confirmation', name: 'app_order_confirmation')]
    public function index(OrderRepository        $orderRepository, OrderStatusHistoryRepository $orderStatusHistoryRepository,
                          EntityManagerInterface $entityManager): Response
    {
        try {

            $sql = "Select * from `order` as o
                    left join order_status_history as osh on o.id = osh._order_id
                    left join status as s on osh.status_id = s.id
                    LEFT JOIN user as u ON o.user_id = u.id
                    where s.name = 'pending'
                    AND o.id NOT IN (
                    SELECT o.id FROM `order` o
                    JOIN order_status_history as osh2 ON o.id = osh2._order_id
                    JOIN status as s2 ON osh2.status_id = s2.id
                    WHERE s2.name = 'confirmed'
                    )
                    AND osh.id = (
                        SELECT MAX(osh3.id)
                        FROM order_status_history osh3
                        WHERE osh3._order_id = o.id
                    );";

            $stmt = $entityManager->getConnection()->prepare($sql);
            $stmt->execute();
//I used FETCH_COLUMN because I only needed one Column.
            $pendingOrders = $stmt->executeQuery()->fetchAll();



//            $pendingOrders = $orderStatusHistoryRepository->createQueryBuilder("o")
//                ->leftJoin('o.status', 's')
//                ->where('s.name = :status')
//                ->setParameter('status', 'pending')
//                ->getQuery()
//                ->getResult();
//            $pendingOrders = $orderRepository
//                    ->createQueryBuilder("o")
//                ->leftJoin('o.orderStatusHistory' , 'osh')
//                ->leftJoin('osh.status' , 's')
//                ->where('s.name = :status')

//                ->createQueryBuilder('o')
//                ->leftJoin('o.orderStatusHistory', 'osh')
//                ->leftJoin('osh.status', 's')
//                ->where('s.name = :status')
//                ->andWhere('o.id NOT IN (
//                SELECT o2.id
//                JOIN o2.orderStatusHistory osh2
//                JOIN osh2.status s2
//                WHERE s2.name = :confirmed
//            )')
//                ->andWhere('osh.id = (
//                SELECT MAX(osh3.id)
//                FROM YourBundle:OrderStatusHistory osh3
//                WHERE osh3.order = o
//            )')
//                ->setParameter('status', 'pending')
//                ->setParameter('confirmed', 'confirmed')
//                ->getQuery()
//                ->getResult();

        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }


        return $this->render('order_confirmation/index.html.twig', [
            'pendingOrders' => $pendingOrders
        ]);
    }

    #[Route('admin/order-rejected/{id}', name: 'app_order_confirmation_rejected')]
    public function rejectOrder($id,Order $order ,  EntityManagerInterface $entityManager, StatusRepository $statusRepository)
    {

        try {

            $beirutTimeZone = new \DateTimeZone("Asia/Beirut");
            $dateTimeInBeirut = new \DateTime("now", $beirutTimeZone);

            $user = $order->getUser();
            $amount = $order->getTotalPrice();

            $currentBalance = $user->getCurrentBalance();
            $newBalance = $currentBalance + $amount;
            $user->setCurrentBalance($newBalance);

            $transaction = new Transaction();
            $transaction->setUser($user);
            $transaction->setIsCredit(1);
            $transaction->setAmount($amount);
            $transaction->setTransactionDate($dateTimeInBeirut);


            $statusEntity = $statusRepository->findOneBy(['name' => 'rejected']);

            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->setStatus($statusEntity);
            $orderStatusHistory->setOrder($order);


            $orderStatusHistory->setStatusUpdateDate($dateTimeInBeirut);

            $entityManager->persist($transaction);
            $entityManager->persist($user);
            $entityManager->persist($orderStatusHistory);
            $entityManager->flush();

            flash()->addFlash("success", "Order was rejected", "Order Rejected");

            return $this->redirectToRoute('app_order_confirmation');

        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }

    }

    #[Route('admin/order-confirmed/{id}', name: 'app_order_confirmation_confirmed')]
    public function confirmOrder($id, Order $order, EntityManagerInterface $entityManager, StatusRepository $statusRepository)
    {

        try {

            $statusEntity = $statusRepository->findOneBy(['name' => 'confirmed']);

            $orderStatusHistory = new OrderStatusHistory();
            $orderStatusHistory->setStatus($statusEntity);
            $orderStatusHistory->setOrder($order);

            $beirutTimeZone = new \DateTimeZone("Asia/Beirut");
            $dateTimeInBeirut = new \DateTime("now", $beirutTimeZone);
            $orderStatusHistory->setStatusUpdateDate($dateTimeInBeirut);

            $entityManager->persist($orderStatusHistory);
            $entityManager->flush();

            flash()->addFlash("success", "Order was confirmed", "Order Confirmed");

            return $this->redirectToRoute('app_order_confirmation');

        } catch (\Exception $exception) {
            throw new \Exception($exception);
        }

    }
}
