<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Order;
use App\Entity\Address;
use App\Entity\Carrier;
use App\Entity\Comment;
use App\Entity\Categorie;
use App\Entity\Jeuxvideo;
use App\Repository\UserRepository;
use App\Repository\AddressRepository;
use App\Repository\CommentRepository;
use App\Repository\CategorieRepository;
use App\Repository\JeuxvideoRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\JeuxvideoCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;



class DashboardController extends AbstractDashboardController
{
    protected $jeuxvideoRepository;
    protected $userRepository;
    protected $categorieRepository;
    protected $commentRepository;

    public function __construct(JeuxvideoRepository $jeuxvideoRepository, UserRepository $userRepository, CategorieRepository $categorieRepository, CommentRepository $commentRepository)
    {
        $this->jeuxvideoRepository = $jeuxvideoRepository;
        $this->userRepository= $userRepository;
        $this->categorieRepository = $categorieRepository;
        $this->commentRepository = $commentRepository;
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //  $routeBuilder = $this->get(AdminUrlGenerator::class);

        // return $this->redirect($routeBuilder->setController(JeuxvideoCrudController::class)->generateUrl());

        // you can also redirect to different pages depending on the current user
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // you can also render some template to display a proper Dashboard
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        return $this->render('bundles/EasyAdminBundle/welcome.html.twig', [
            'countAllUser' => $this->userRepository->countAllUser(),
            'countAllJeuxvideo' => $this->jeuxvideoRepository->countAllJeuxvideo(),
            'countAllCategorie' => $this->categorieRepository->countAllCategorie(),
            'countAllComment' => $this->commentRepository->countAllComment(),
            'jeuxvideo' => $this->jeuxvideoRepository->findAll()
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('GamingGeek');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Adresses', 'fas fa-map-marked', Address::class);
        yield MenuItem::linkToCrud('Commandes', 'fas fa-shopping-cart', Order::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('Jeux Video', 'fas fa-tablet-alt', Jeuxvideo::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-tag', Comment::class);
        yield MenuItem::linkToCrud('Transporteurs', 'fas fa-truck', Carrier::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
                        ->setName($user->getUsername())
                        ->setGravatarEmail($user->getUsername())
                        ->displayUserAvatar(true)
        ;
    }

    
}
