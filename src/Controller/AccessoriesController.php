<?php

namespace App\Controller;


use App\Repository\CategoryRepository;
use App\Repository\ItemRepository;
use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class AccessoriesController extends AbstractController
{


    #[Route('accessories' , name: 'app_accessories')]
    public function index( ItemRepository $itemRepository , TypeRepository $typeRepository , CategoryRepository $categoryRepository): Response
    {


        $categories = $categoryRepository->createQueryBuilder('c')
            ->join('c.items' , 'i')
            ->join('i.type' , 't')
            ->where('t.name = :toto')
            ->setParameter('toto' , 'Accessories')
            ->getQuery()
            ->getResult();

        return $this->render('accessories/index.html.twig' , [

            'categories' => $categories,
            'user' => $this->getUser()

        ]);

    }

    #[Route('accessories/{id}')]
    public function checkToAddToCarte($id , ItemRepository $itemRepository){



            $item = $itemRepository->find($id);

//        dd($accessory);
            if($item){
                return  $this->json($item ,  Response::HTTP_OK, context: ['groups'=> ['add-accessory-to-carte']]);
            }else{
                throw new BadRequestHttpException('Error');
//                return new JsonResponse([
//                    'statusCode' => 404 ,
//                    'data' => null
//                ],
//                    404);
            }

    }
}
