<?php

namespace App\Controller;

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

        $qb = $orderRepository->createQueryBuilder('o')
            ->getQuery()
            ->getResult();

        $pagination = $paginator->paginate(
            $qb ,
            $request->query->get("page" ,1),
            10
        );

        if($orders){

            return $this->render('my_orders/index.html.twig', [
                'orders' => $pagination
            ]);
        }else{
            return $this->render('my_orders/index.html.twig', [
                'orders' => null
            ]);
        }


    }
}
