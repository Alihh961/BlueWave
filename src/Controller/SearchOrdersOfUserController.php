<?php

namespace App\Controller;

use App\Form\SearchOrdersByUserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchOrdersOfUserController extends AbstractController
{
    #[Route('/admin/orders/search', name: 'app_search_orders_of_user')]
    public function index(Request $request, UserRepository $userRepository): Response
    {


        $form = $this->createForm(SearchOrdersByUserFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user = $data['user'];
            $numberOfOrders = $data['numberOfOrders'];
            $ordersBoolean = true;

            // insure that the number of orders
            if(!$numberOfOrders == 'all'){
                $numberOfOrders = 10;
            }

            if (!$user) {

                $user = null;
            }

            // we use a boolean value to decide if we display no orders message or no
            if($user->getOrders()->toArray()){
                $ordersBoolean = false;
            }


            if ($user) {
                return $this->render('search_orders_of_user/index.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
                    'orderBoolean' => $ordersBoolean,
                    'numberOfOrders' => $numberOfOrders
                ]);
            }

        }


        return $this->render('search_orders_of_user/index.html.twig', [
            'form' => $form->createView(),

        ]);
    }
}
