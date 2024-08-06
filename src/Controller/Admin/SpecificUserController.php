<?php

namespace App\Controller\Admin;


use App\Form\SpecificUserFormType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SpecificUserController extends AbstractController
{


    #[Route('admin/specific-user', name:'app_user_specific')]
    public function index(Request $request , UserRepository $userRepository)
    {

        $user = null;

        $form = $this->createForm(SpecificUserFormType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()){

            $email = $form->get('email')->getData();

            $phoneNumber = $form->get('phoneNumber')->getData();

            if($email){
                $user = $userRepository->findOneBy(['email' => $email]);

            }else if($phoneNumber){

                $user = $userRepository->findOneBy(['phoneNumber' => $phoneNumber]);

            }

        }

       return $this->render('view_user_details/specific-user-details-admin.html.twig',
       [
           'form' => $form->createView(),
           'user' => $user
       ]);

    }
}
