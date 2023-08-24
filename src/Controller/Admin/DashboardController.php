<?php

namespace App\Controller\Admin;

use App\Entity\Recipe;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Instructions;
use App\Entity\RecipeIngredient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    ) {
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(RecipeCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de bord');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::subMenu('Recette', 'fas fa-book')->setSubItems([
            MenuItem::linkToCrud('Toutes les recettes', 'fas fa-swatchbook', Recipe::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Recipe::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Ingrédient', 'fas fa-bowl-rice', RecipeIngredient::class),
            MenuItem::linkToCrud('Catégorie', 'fas fa-list', Category::class)
                ->setQueryParameter('categoryType', 'recipe'),
        ]);

        yield MenuItem::subMenu('Article', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les articles', 'fas fa-swatchbook', Article::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Catégorie', 'fas fa-list', Category::class)
                ->setQueryParameter('categoryType', 'article'),
        ]);
    }
}
