<?php

namespace App\Controller;


use App\Repository\AccCategoryRepository;
use App\Repository\AccessoriesRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccessoriesController extends AbstractController{


    public function __construct(
        private AccessoriesRepository $accessoriesRepository,
        private AccCategoryRepository $accCategoryRepository
    )
    {
    }

    #[Route(path: '/accessories', name: 'app_accessories')]
    public function index(){

        $accessories = $this->accessoriesRepository->findAll();

        $accCategories = $this->accCategoryRepository->findAll();


        return $this->render('accessories/index.html.twig',[
            'accessories' => $accessories,
            'categories' => $accCategories
        ]);

    }

}
