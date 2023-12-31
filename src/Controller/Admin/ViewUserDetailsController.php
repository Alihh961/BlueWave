<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewUserDetailsController extends AbstractController
{
    #[Route('/admin/user/{id}', name: 'app_view_user_details')]
    public function index(Request $request , $id , User $user): Response
    {

        return $this->render('view_user_details/index.html.twig', [
            'user' => $user
        ]);
    }
}
