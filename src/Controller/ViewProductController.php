<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ViewProductController extends AbstractController
{

    #[Route('view-product')]
    public function index(Request $request, HttpClientInterface $httpClient,CategoryRepository $categoryRepository)
    {

        $categoryId = $request->query->get('c');

        $categoryEntity = $categoryRepository->find($categoryId);

        $items =$categoryEntity->getItems();



        return $this->render("view-products/index.html.twig", [
            "items" => $items
        ]);


    }
}


