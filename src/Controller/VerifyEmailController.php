<?php

namespace App\Controller;

use App\Repository\InscriptionVerificationCodeRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class VerifyEmailController extends AbstractController
{


    #[Route('verify-email')]
    public function verifyEmail(Request $request, UserRepository $userRepository, EntityManagerInterface $entityManager , InscriptionVerificationCodeRepository $codeRepository)
    {
        $receivedVerificatonCode = $request->query->get('vc');
        $userEmail = $request->query->get('e');

        $user = $userRepository->findOneBy(['email' => $userEmail]);

        $verificatonCode = $user->getInscriptionVerificationCode()->getVerificationCode();

        if ($verificatonCode == $receivedVerificatonCode && !$user->isVerified()) {
            $user->setIsVerified(true);

            $entityManager->persist($user);
            $entityManager->flush();

            $url = $this->generateUrl('app_login', ['f' => True]);
            return $this->redirect($url);
        } else {

            $url = $this->generateUrl('app_home', ['fe' => true]);
            return $this->redirect($url);
        }


    }

}
