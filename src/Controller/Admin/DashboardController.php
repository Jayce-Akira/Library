<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use App\Entity\Loan;
use App\Entity\Type;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Chapelle-Curreaux')
            ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-thin fa-book-bookmark', User::class);
        yield MenuItem::linkToCrud('Prêt', 'fa fa-solid fa-bookmark', Loan::class);
        yield MenuItem::linkToCrud('Livres', 'fa fa-solid fa-book', Book::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-thin fa-book-bookmark', Type::class);
    }
}
