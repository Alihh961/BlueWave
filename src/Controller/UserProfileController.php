<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\AddBalanceFormType;
use App\Form\EditProfileFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserProfileController extends AbstractController
{

    #[Route('/user/profile/edit', name: 'app_user_profile_edit')]
    public function editProfile(Request                $request, UserPasswordHasherInterface $userPasswordHasher,
                                EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();

        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $phoneNumber = $user->getPhoneNumber();


        $form = $this->createForm(EditProfileFormType::class, null, [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'phoneNumber' => $phoneNumber
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $firstName = $data['firstName'];
            $lastName = $data['lastName'];
            $phoneNumber = $data['phoneNumber'];


            if ($firstName) {
                $user->setFirstName($firstName);
            }
            if ($lastName) {
                $user->setLastName($lastName);
            }
            if ($phoneNumber) {
                $user->setPhoneNumber($phoneNumber);
            }

            $entityManager->persist($user);
            $entityManager->flush();

            flash()->addFlash('success', "Changes took place", 'Profile Edit');

            $this->redirectToRoute('app_home');
        }
        return $this->render('user_profile/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/user/profile' , name: 'app_user_profile')]
    public function show()
    {

        $user = $this->getUser();


        return $this->render('user_profile/show.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('admin/add-balance' , name: 'app_add_balance')]
    public function addBalance(UserRepository $userRepository , Request $request , EntityManagerInterface $entityManager)
    {

        $users = $userRepository->findAll();
        $emails = [];

        foreach ($users as $user){
            $emails[$user->getEmail()] = $user->getEmail();
        }

        $form = $this->createForm(AddBalanceFormType::class);
        $form->handleRequest($request);

        try{
            if($form->isSubmitted() && $form->isValid()){
                $data = $form->getData();

                $amount = $data['amount'];

                $transactionType = $data['transactionType'];

                $user = $data['user'];

                $currentBalance = $user->getCurrentBalance();


                // if the transaction type is credit
                if($transactionType){
                    $newBalance = $currentBalance + $amount;
                }else{
                    $newBalance = $currentBalance - $amount;

                }

                $user->setCurrentBalance($newBalance);

                $beirutTimeZone = new \DateTimeZone("Asia/Beirut");
                $dateTimeInBeirut = new \DateTime("now", $beirutTimeZone);

                $transaction = new Transaction();

                $transaction->setUser($user);
                $transaction->setTransactionDate($dateTimeInBeirut);
                $transaction->setAmount($amount);
                $transaction->setIsCredit($transactionType);

                $entityManager->persist($transaction);
                $entityManager->flush();

                flash()->addFlash('success', "Balance updated with success", 'Balance Updated');

                return $this->redirect('/admin');

            }
        }
        catch(\Exception $exception){
            throw new \Exception($exception);
        }



        return $this->render('add_balance/index.html.twig', [
            'emails' => $emails,
            'form' => $form->createView()
        ]);
    }

}
