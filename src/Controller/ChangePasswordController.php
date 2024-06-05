<?php

namespace App\Controller;

use App\Entity\ResetPasswordRequest;
use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\ResetPasswordType;
use App\Form\SetNewPasswordType;
use App\Repository\ResetPasswordRequestRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Exception\BaseException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\NativePasswordHasher;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChangePasswordController extends AbstractController
{

    private $hasher;


    public function __construct(

        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface      $entityManager,
        private HttpClientInterface         $httpClient
    )
    {

        $this->hasher = new NativePasswordHasher();
    }

    #[Route('/user/change-password', name: 'app_change_password')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {


        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);
        $user = $this->getUser();

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $password = $data['password'];
            $user = $this->getUser();

            $currentPassword = $data['currentPassword'];

            if (!$this->userPasswordHasher->isPasswordValid($user, $currentPassword)) {

                flash()->addFlash("error", "The password wasn't changed", "Wrong current password");
                return $this->redirectToRoute('app_change_password');
            }

            if ($password) {

                $hashedPassword = $this->userPasswordHasher->hashPassword($user, $password);
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


    #[Route('/reset-password', name: 'app_reset_password')]
    public function forgot(Request $request, UserRepository $userRepository)
    {


        $form = $this->createForm(ResetPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];

            $user = $userRepository->findOneBy(['email' => $email]);

            if ($user) {

                $baseUrl = $_ENV['PROJECT_URL'];

                $brevoApiKey = $_ENV['BREVO_API_KEY'];

                $token = uniqid();
                $hashedToken = $this->hasher->hash($token);


                // check if the user already request a reset password so we will override it
                $resetPasswordRequest = $user->getResetPasswordRequest();

                if (!$resetPasswordRequest) {
                    $resetPasswordRequest->setUser($user);

                }

                $requestedAt = new \DateTimeImmutable('now', new \DateTimeZone('Asia/Beirut'));
                $expiresAt = $requestedAt->add(new \DateInterval('PT2H'));

//                $formatedRequestedAt = $requestedAt->format('Y-m-d H:i:s');
//                $formatedExpiresAt = $expiresAt->format('Y-m-d H:i:s');

                $resetPasswordRequest->setRequestedAt($requestedAt);
                $resetPasswordRequest->setExpiresAt($expiresAt);
                $resetPasswordRequest->setHashedToken($hashedToken);


                $firstName = $user->getFirstName();
                $userEmail = $user->getEmail();


                try {

                    $verificationUrl = $baseUrl . "/reset-code?ht=" . $hashedToken . "&e=" . urlencode($userEmail);

                    $response = $this->httpClient->request('POST', "https://api.brevo.com/v3/smtp/email", [
                        'headers' => [
                            'accept' => 'application/json',
                            'api-key' => $brevoApiKey,
                            'content-type' => 'application/json'
                        ],
                        'json' => [
                            "sender" => [
                                'name' => 'Blue Wave Mobiles - Reset Password',
                                'email' => 'no-reply@bluewavemobiles.com'
                            ],
                            "to" => [
                                [
                                    'email' => $userEmail,
                                    'name' => $firstName,
                                ],
                            ],
                            "subject" => 'Verification email',
                            "htmlContent" => "
            <p>Hello <span style='font-weight: bolder'> $firstName </span>, click the button below to set a new password</p>
            <a href=\"$verificationUrl\" style='padding: 5px 10px; background-color: #1c7430; text-decoration: none; color: white; border-radius: 5px; display: inline-block'>Click here</a>
        "
                        ]
                    ]);


                    $this->entityManager->persist($resetPasswordRequest);
                    $this->entityManager->flush();

                    return $this->render('reset-password/afterReset.html.twig' , [
                        'message' => 'Please check your email inbox to continue the process!'
                    ]);


                } catch (\Exception$e) {

                    return $this->json($e->getMessage());
                }

            }
            return $this->render('reset-password/afterReset.html.twig' , [
                'message' => 'Please check your email inbox to continue the process!'
            ]);


        }

        return $this->render('reset-password/reset-password.html.twig', [
            'form' => $form->createView()
        ]);
    }


    #[Route('reset-code', name: 'app_reset_code')]
    public function reset(Request $request, UserRepository $userRepository, ResetPasswordRequestRepository $resetPasswordRequestRepository)
    {

        $hashedToken = $request->query->get('ht');
        $email = urldecode($request->query->get('e'));
        $user = $userRepository->findOneBy(['email' => $email]);


        if (!$email || !$hashedToken || !$user) {

            return $this->render('reset-password/errorWhileResetting.html.twig');

        }

        $decodedHashedToken = urldecode($hashedToken);
        $hashedTokenInDB = $user->getResetPasswordRequest()->getHashedToken();

        if($hashedTokenInDB === '123'){

            return $this->render('reset-password/errorWhileResetting.html.twig');
        }

        if (!($decodedHashedToken === $hashedTokenInDB)) {

            return $this->render('reset-password/errorWhileResetting.html.twig');

        }

        $form = $this->createForm(SetNewPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();

            $newPassword = $data['password'];
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $newPassword);

            $user->setPassword($hashedPassword);

            $resetPasswordEntity = $resetPasswordRequestRepository->findOneBy(['user' => $user]);

            $resetPasswordEntity->setHashedToken('123');

//            $this->entityManager->remove($resetPasswordEntity);

            $this->entityManager->persist($user);
            $this->entityManager->flush();


            return $this->render('reset-password/afterReset.html.twig', [
                'message' => 'Password reset successfully!'
            ]);


        }

        return $this->render('reset-password/setNewPassword.html.twig', [
            'form' => $form
        ]);
    }

}
