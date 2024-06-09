<?php

namespace App\Controller;







use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;


class TelecommunicationController extends AbstractController{

    #[Route('/telecommunication', name: 'app_telecommunication')]
    public function index(Request $request,ItemRepository $itemRepository){

        $categoryName = $request->query->get('cn');

        if(!$categoryName){

            return $this->redirectToRoute('app_home');
        }


        $items = $itemRepository->createQueryBuilder('i')
            ->join('i.category' , 'c')
            ->where('c.name = :categoryName')
            ->setParameter('categoryName' , $categoryName)
            ->getQuery()
            ->getResult();


        return $this->render('tele/index.html.twig' , [
            'items' => $items
        ]);

    }

}
