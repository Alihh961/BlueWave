<?php

namespace App\Controller;

use App\Form\ChangePasswordFormType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Exception\BaseException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class ChangePasswordController extends AbstractController
{
    #[Route('/user/change-password', name: 'app_change_password')]
    public function index(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {


        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $password = $data['password'];
            $user = $this->getUser();

            $currentPassword = $data['currentPassword'];

            if (!$userPasswordHasher->isPasswordValid($user, $currentPassword)) {

                flash()->addFlash("error", "The password wasn't changed", "Wrong current password");
                return $this->redirectToRoute('app_change_password');
            }

            if ($password) {

                $hashedPassword = $userPasswordHasher->hashPassword($user, $password);
                $user->setPassword($hashedPassword);

                try {
                    $entityManager->persist($user);
                    $entityManager->flush();

                    flash()->addFlash("success", "Password updated with success", "Password Updated");
                    return $this->redirectToRoute("app_home");

                } catch (\Exception $exception) {
                    throw new \Exception($exception);
                }


            }
        }


        return $this->render('change_password/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
