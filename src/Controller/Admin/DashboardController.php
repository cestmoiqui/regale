<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Article;
use App\Entity\RecipeCategory;
use App\Entity\ArticleCategory;
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

    #[Route('/', name: 'app_home')]
    public function home(): Response
    {

        return $this->render('home/index.html.twig');
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/home.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Une Cuisine Connectée')
            ->setFaviconPath('images/icon-cmqr.png');
    }

    public function configureMenuItems(): iterable
    {

        yield MenuItem::linkToRoute('Tableau de board', 'fa fa-kitchen-set', 'admin');
        yield MenuItem::linkToRoute('C\'est Moi Qui Régale', 'fa fa-home', 'app_home');

        if ($this->isGranted('ROLE_SUPER_ADMIN')) {
            yield MenuItem::subMenu('Utilisateur', 'fa fa-users')->setSubItems([
                MenuItem::linkToCrud('Tous les utilisateurs', 'fas fa-swatchbook', User::class),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus', User::class)->setAction(Crud::PAGE_NEW),
            ]);
        }

        yield MenuItem::subMenu('Recette', 'fas fa-book')->setSubItems([
            MenuItem::linkToCrud('Toutes les recettes', 'fas fa-swatchbook', Recipe::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Recipe::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Catégorie', 'fab fa-delicious', RecipeCategory::class),
        ]);

        yield MenuItem::subMenu('Article', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les articles', 'fas fa-swatchbook', Article::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Catégorie', 'fab fa-delicious', ArticleCategory::class),
        ]);

        yield MenuItem::subMenu('Menus', 'fas fa-list')->setSubItems([
            MenuItem::linkToCrud('Article', 'fas fa-newspaper', Menu::class)
                ->setQueryParameter('submenuIndex', 0),
            MenuItem::linkToCrud('Recette', 'fas fa-book', Menu::class)
                ->setQueryParameter('submenuIndex', 1),
            MenuItem::linkToCrud('Liens personnalisés', 'fas fa-link', Menu::class)
                ->setQueryParameter('submenuIndex', 2),
        ]);
    }
}
