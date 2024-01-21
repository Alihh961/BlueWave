<?php

namespace App\Controller\Admin;

use App\Entity\Attributes;
use App\Entity\Category;
use App\Entity\Type;
use App\Entity\VisionItem;
use App\Entity\ItemType;
use App\Entity\Order;
use App\Entity\OrderStatusHistory;
use App\Entity\Params;
use App\Entity\Status;
use App\Entity\Transaction;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(UserCrudController::class)
            ->generateUrl();


        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="img.png" style="border-radius: 50%;display: block; width: 95px;margin: auto">')
            ->renderContentMaximized();
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('easyAdminJs')
            ->addWebpackEncoreEntry('easyAdminScss');
    }


    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToUrl('Go to Home Page', 'fa fa-home', $this->generateUrl('app_home'))
            ->setCssClass("bg-primary p-2 border-radius mb-2");

        yield MenuItem::linkToUrl("Add / Edit Balance", 'fas fa-dollar-sign', 'admin/add-balance')
            ->setCssClass('bg-success p-2 border-radius mb-2');

        yield MenuItem::linkToDashboard('Dashboard Page', 'fa-solid fa-cruzeiro-sign')
            ->setCssClass("bg-secondary p-2 border-radius mb-2 ");

        yield MenuItem::linkToUrl("Search Orders By User", 'fas fa-shopping-cart', 'admin/orders/search')
            ->setCssClass('bg-danger p-2 border-radius mb-2');

        yield MenuItem::linkToUrl("Orders Confirmation", 'fas fa-shopping-cart', 'admin/orders-confirmation')
            ->setCssClass('bg-primary p-2 border-radius mb-2');

        yield MenuItem::linkToUrl("Diff Prices /Missed Items", 'fas fa-shopping-cart', 'admin/comparing-price')
            ->setCssClass('bg-primary p-2 border-radius mb-2');

        yield MenuItem::subMenu("Users", 'fa fa-user')
            ->setCssClass("p-2 ")
            ->setSubItems([
                MenuItem::linkToCrud("Create a user", "fa fa-plus", User::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud("All users", "fa fa-eye", User::class)->setAction(Crud::PAGE_INDEX),
                MenuItem::linkToCrud("Specific User", "fa fa-eye", User::class)->setAction(Crud::PAGE_DETAIL)


            ]);


        yield MenuItem::subMenu("Vision Items", 'fa fa-user')
            ->setCssClass('p-2')
            ->setSubItems([
                MenuItem::linkToCrud("Create a vision Item", "fa fa-plus", VisionItem::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud("All vision items", "fa fa-eye", VisionItem::class)->setAction(Crud::PAGE_INDEX)

            ]);


        yield MenuItem::subMenu("Items Type", 'fa fa-user')
            ->setCssClass('p-2')
            ->setSubItems([
                MenuItem::linkToCrud("Create a type", "fa fa-plus", ItemType::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud("All types", "fa fa-eye", ItemType::class)->setAction(Crud::PAGE_INDEX)

            ]);

        yield MenuItem::subMenu("Type", 'fa fa-user')
            ->setCssClass('p-2')
            ->setSubItems([
                MenuItem::linkToCrud("Create a vision Item", "fa fa-plus", Type::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud("All vision items", "fa fa-eye", Type::class)->setAction(Crud::PAGE_INDEX)

            ]);

        yield MenuItem::subMenu("Category", 'fa fa-user')
            ->setCssClass('p-2 ')
            ->setSubItems([
                MenuItem::linkToCrud("Create a category", "fa fa-plus", Category::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud("All categories", "fa fa-eye", Category::class)->setAction(Crud::PAGE_INDEX)

            ]);

        yield MenuItem::subMenu("Params", 'fa fa-user')
            ->setCssClass('p-2')
            ->setSubItems([
                MenuItem::linkToCrud("Create a param", "fa fa-plus", Params::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud("All params", "fa fa-eye", Params::class)->setAction(Crud::PAGE_INDEX)

            ]);


        yield MenuItem::subMenu("Status", 'fa fa-code-compare')
            ->setCssClass('p-2')
            ->setSubItems([
                MenuItem::linkToCrud("Create a status", "fa fa-plus", Status::class)->setAction(Crud::PAGE_NEW),
                MenuItem::linkToCrud("All statuses", "fa fa-eye", Status::class)->setAction(Crud::PAGE_INDEX)

            ]);

        yield MenuItem::subMenu("Order", 'fa-solid fa-cubes')
            ->setCssClass('p-2')
            ->setSubItems([
                MenuItem::linkToCrud("All orders", "fa fa-eye", Order::class)->setAction(Crud::PAGE_INDEX)

            ]);

        yield MenuItem::subMenu("Orders History", 'fa-solid fa-clock-rotate-left')
            ->setCssClass('p-2')
            ->setSubItems([
                MenuItem::linkToCrud("All orders history", "fa fa-eye", OrderStatusHistory::class)->setAction(Crud::PAGE_INDEX)

            ]);

        yield MenuItem::subMenu("Transactions", 'fa-regular fa-newspaper')
            ->setCssClass('p-2')
            ->setSubItems([
                MenuItem::linkToCrud("All transactions", "fa fa-eye", Transaction::class)->setAction(Crud::PAGE_INDEX)

            ]);
    }
}
