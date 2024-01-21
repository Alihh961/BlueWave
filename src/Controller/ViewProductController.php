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
    public function index(Request $request, HttpClientInterface $httpClient, CategoryRepository $categoryRepository)
    {

        $categoryId = $request->query->get('c');

        $categoryEntity = $categoryRepository->find($categoryId);

        $items = $categoryEntity->getItems();

        foreach ($items as $item) {
            // ensure that min and max aren't equal
            if ($item->getAttributes()->getMinAndMax() && $item->getAttributes()->getMinAndMax()[0] != $item->getAttributes()->getMinAndMax()[1]) {
                $min = $item->getAttributes()->getMinAndMax()[0];


                $price = $item->getPrice() * $min;

                $item->setPrice($price);
            }
        }


        return $this->render("view-products/index.html.twig", [
            "items" => $items
        ]);


    }
}


