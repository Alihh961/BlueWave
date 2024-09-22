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
use Symfony\Component\HttpFoundation\JsonResponse;
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
                "success" => true,
                "user" => $this->getUser()
            ]
        );

    }

    #[Route('/load-categories', name: 'app_load_more')]
    public function load(Request $request, CategoryRepository $categoryRepository)
    {

        $offset = $request->query->getInt('offset') * 10;


        $isMax = false;

        $categoriesMaxQuantity = $categoryRepository->countCategoriesWithItemsOfType('E-charges');

        if ($offset >= $categoriesMaxQuantity) {
            $isMax = true;
        }

            $categories = $categoryRepository->getCategoriesWithItemsOfType('E-charges' , $offset , 10);


        return $this->json(['categories' => $categories, 'max' => $isMax , 'offSet' =>$offset /10], context: ['groups' => ['categories']]);
    }

    /// No need for this route, I guess
    #[Route('/max-vision-items')]
    public function max(Request $request, CategoryRepository $categoryRepository)
    {


        $itemsMaxQuantity = count($categoryRepository->findAll());

        return $this->json(['max' => $itemsMaxQuantity]);
    }

    #[Route('/search-categories-by-name')]
    public function searchCategoriesByName(Request $request, CategoryRepository $categoryRepository): JsonResponse
    {
        $name = $request->query->get('n');
        $offset = $request->query->get('offset', 0);

        $categories = $categoryRepository->createQueryBuilder('c')
            ->select('c.name, c.url, c.id, COUNT(i.id) as itemsCount')
            ->innerJoin('c.items', 'i')
            ->innerJoin('i.type', 't')                
            ->where('c.name LIKE :name')              
            ->andWhere('t.name = :type')       
            ->setParameter('name', '%' . $name . '%')  
            ->setParameter('type', 'E-charges')       
            ->groupBy('c.id')                       
            ->having('COUNT(i.id) > 0')           
            ->setFirstResult($offset)       
            ->setMaxResults(10)                     
            ->getQuery()
            ->getResult();
    
        return $this->json(['categories' => $categories]);
    }
    


}
