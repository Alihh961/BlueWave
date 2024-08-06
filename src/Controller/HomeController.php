<?php

namespace App\Controller;

use App\Entity\Attributes;
use App\Entity\Category;
use App\Entity\Params;
use App\Entity\Item;
use App\Form\SearchTypeFormType;
use App\Repository\CategoryRepository;
use App\Repository\ItemTypeRepository;
use App\Repository\ParamsRepository;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class HomeController extends AbstractController
{

    public function __construct(
        private PaginatorInterface $paginator
    )
    {
    }

    #[Route('/', name: 'app_home')]
    public function index(HttpClientInterface $httpClient, ItemRepository $visionItemRepository
        , CategoryRepository                  $categoryRepository, Request $request): Response
    {

        $flashError = $request->query->get('fe') ?: false;
        $flashErrorResetCode = $request->query->get('rce') ?: false;

        if($flashErrorResetCode){
            flash()->addFlash('error', 'Something went wrong', 'Error');
        }

        if ($flashError) {
            flash()->addFlash('error', 'Something went wrong, contact us if the problem insists', 'Account not verified');
        }

        $qb = $categoryRepository->createQueryBuilder('c')
            ->join('c.items' , 'i')
            ->join('i.type' , 't')
            ->where('t.name = :toto')
            ->setParameter('toto' , 'E-charges');

        $form = $this->createForm(SearchTypeFormType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $gameName = $data['gameName'];

            if ($gameName != null) {
                $qb->andWhere("c.name LIKE :name")
                    ->setParameter("name", "%" . $gameName . "%")
                    ->orderBy('c.id');
            }

        }


        $pagination = $this->paginator->paginate(
            $qb,
            $request->query->getInt("page", 1),
            15);

        return $this->render(
            'home/index.html.twig', [
                "categories" => $pagination,
                "form" => $form->createView(),
                "success" => true
            ]
        );

    }

    #[Route('/load-more', name: 'app_load_more')]
    public function load(Request $request, CategoryRepository $categoryRepository)
    {

        $offset = $request->query->getInt('offset');


        $isMax = false;

        $itemsMaxQuantity = count($categoryRepository->findAll());

        if ($offset >= $itemsMaxQuantity) {
            $isMax = true;
        }
        $items = $categoryRepository->createQueryBuilder('c')
            ->setFirstResult($offset)
            ->setMaxResults(15)
            ->getQuery()
            ->getResult();


        return $this->json(['items' => $items, 'max' => $isMax], context: ['groups' => ['categories']]);
    }

    #[Route('/max-vision-items')]
    public function max(Request $request, CategoryRepository $categoryRepository)
    {


        $itemsMaxQuantity = count($categoryRepository->findAll());

        return $this->json(['max' => $itemsMaxQuantity]);
    }


}
