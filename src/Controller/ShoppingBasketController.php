<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class ShoppingBasketController extends AbstractController{


    #[Route('/shopping-basket')]
    public function index(){

        return $this->render('basket/index.html.twig');

    }

}
