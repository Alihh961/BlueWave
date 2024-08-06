<?php

namespace App\Controller;

use App\Entity\Order;
use App\Repository\OrderRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyOrdersController extends AbstractController
{
    #[Route('user/my-orders', name: 'app_my_orders')]
    public function index(PaginatorInterface $paginator , OrderRepository $orderRepository , Request $request): Response
    {

        $user = $this->getUser();
        $orders = $user->getOrders()->toArray();


        $totalOrders = count($orders);

        $qb = $orderRepository->createQueryBuilder('o')
            ->where('o.user = :user')
            ->setParameter('user' , $user)
            ->orderBy('o.createdAt' , 'DESC')
            ->getQuery()
            ->getResult();

        $pagination = $paginator->paginate(
            $qb ,
            $request->query->get("page" ,1),
            10
        );



        if($orders){

            foreach ($orders as $order){
                $itemsName = $order->getItem();
                $order->setItem(str_replace('}' , '=>' , $itemsName));
            }


            return $this->render('my_orders/index.html.twig', [
                'orders' => $pagination,
                'totalOrders' =>$totalOrders
            ]);
        }else{
            return $this->render('my_orders/index.html.twig', [
                'orders' => null
            ]);
        }


    }
}
