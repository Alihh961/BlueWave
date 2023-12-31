<?php

namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderStatusHistory;
use App\Entity\Params;
use App\Entity\Status;
use App\Entity\Transaction;
use App\Form\PackageFormType;
use App\Repository\OrderStatusHistoryRepository;
use App\Repository\StatusRepository;
use App\Repository\VisionItemRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Timezone;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Uid\Uuid;

class CheckoutController extends AbstractController
{


    #[Route("/checkout")]
    public function index(Request                      $request, HttpClientInterface $httpClient, EntityManagerInterface $entityManager,
                          OrderStatusHistoryRepository $orderStatusHistoryRepository, StatusRepository $statusRepository, VisionItemRepository $visionItemRepository)
    {

        $itemId = $request->query->get('i');
        $visionItem = $visionItemRepository->find($itemId);

        if ($visionItem) {

            $categoryName = $visionItem->getCategory()->getName();
            $price = $visionItem->getPrice();

            $params = $visionItem->getParams();

            $paramsInput = [];
            foreach ($params as $param) {
                $paramsInput [] = $param->getName();

            }

            $minAndMax = $visionItem->getAttributes()->getMinAndMax();

            $range = [];
            if ($minAndMax) {
                $min = $minAndMax[0];
                $max = $minAndMax[1];

                if (is_array($min) || is_array($max)) {
                    $min = $min[0];
                    $max = $max[0];
                }

            } else {
                $min = $max = null;
            }


            $form = $this->createForm(PackageFormType::class, null, [
                "paramsInput" => $paramsInput,
                "min" => $min,
                "max" => $max,
                "categoryName" => $categoryName,
                "price" => $price
            ]);

            try {


                $form->handleRequest($request);

                if ($form->isSubmitted() && $form->isValid()) {
                    $user = $this->getUser();


                    if ($user) {

                        $data = $form->getData();


                        $productType = $visionItem->getItemType()->getName();

                        $quantity = $data['quantity'] ?? 1;

                        $totalPrice = $price * $quantity;
                        $userBalance = $user->getCurrentBalance();
                        if($totalPrice > $userBalance){
                            flash()->addFlash("error" , "You must recharge your account" , "Insufficient Funds");
                            return $this->redirect($request->getUri());
                        }


                        $paramsEntered = "";
                        foreach ($paramsInput as $paramInput) {
                            $paramInput = str_replace(" ", "", $paramInput);
                            if ($data[$paramInput]) {

                                $paramsEntered .= $paramInput . " => " . $data[$paramInput] . ";";


                            } else {
                                throw new \Exception('Params Error');
                            }
                        }




                        $beirutTimeZone = new \DateTimeZone("Asia/Beirut");
                        $dateTimeInBeirut = new \DateTime("now", $beirutTimeZone);

                        $currentStatus = $statusRepository->findOneBy(['name' => 'pending']);


                        $namespace = Uuid::v4();
                        $uuid = Uuid::v5($namespace, $visionItem->getCategory()->getName());
                        $orderNumber = $uuid->toRfc4122();


                        $order = new Order();
                        $order->setOrderReference($orderNumber);
                        $order->setPrice($price);
                        $order->setTotalPrice($totalPrice);
                        $order->setParamsEntered($paramsEntered);
                        $order->setUser($user);
                        $order->setCreatedAt($dateTimeInBeirut);
                        $order->setItem($visionItem->getName());
                        $order->setQuantity($quantity);

                        $orderStatusHistory = new OrderStatusHistory();
                        $orderStatusHistory->setOrder($order);
                        $orderStatusHistory->setStatus($currentStatus);
                        $orderStatusHistory->setStatusUpdateDate($dateTimeInBeirut);

                        $order->addOrderStatusHistory($orderStatusHistory);

                        $transaction = new Transaction();
                        $transaction->setUser($user);
                        $transaction->setTransactionDate($dateTimeInBeirut);
                        $transaction->setAmount($totalPrice);
                        $transaction->setIsCredit(false);

                        $newBalance = $userBalance - $totalPrice;
                        $user->setCurrentBalance($newBalance);


                        $entityManager->persist($transaction);
                        $entityManager->persist($order);
                        $entityManager->flush();


                        flash()->addFlash('info', "Your order has been placed! It will be confirmed soon.", 'Pending');

                        $url = $this->generateUrl('app_home');

                        return $this->redirect($url);
                    }
                    flash()->addInfo("You need to sign in first" , 'Not Signed In' );



                }
            } catch (\Exception $exception) {
                throw new \Exception($exception);
            }


            return $this->render("checkout/index.html.twig", [
                "item" => $visionItem,
                "min" => $min,
                "max" => $max,
                "form" => $form->createView(),
                "params" => $params
            ]);


        } else {

            return new JsonResponse(["message" => "Error, product not found"], 404);
        }


    }
}
