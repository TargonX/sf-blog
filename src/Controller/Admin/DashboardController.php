<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class DashboardController extends AbstractDashboardController 
{

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // You can make your dashboard redirect to some common page of your backend
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(PostCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('Panel administracyjny');

    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Posts', 'fa fa-tags', Post::class);
        yield MenuItem::linkToCrud('Comments', 'fa fa-tags', Comment::class);
      
    }
}
