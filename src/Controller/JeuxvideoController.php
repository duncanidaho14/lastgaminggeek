<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Comment;
use App\Entity\Jeuxvideo;
use App\Form\JeuxvideoType;
use App\Repository\UserRepository;
use App\Repository\JeuxvideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security as SecurityCore;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\CommentType;
use App\Entity\Categorie;



class JeuxvideoController extends AbstractController
{
    /**
     * @var Security
     */
    private $security;

    public function __construct(SecurityCore $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/mes-jeux", name="jeuxvideo")
     * @Security("is_granted('ROLE_USER')", message="Ce jeux video ne vous appartient pas, vous ne pouvez pas le voir")
     * 
     * This function will find all the games that belong to the user who is currently logged in and
     * display them on the page.
     * 
     * @param JeuxvideoRepository jeuxvideoInstance the repository instance
     * 
     * @return Response The user's games
     */
    public function index(JeuxvideoRepository $jeuxvideoInstance): Response
    {
        return $this->render('jeuxvideo/mesjeux.html.twig', [
            'jeuxvideo' => $jeuxvideoInstance->findBy(array('user' => $this->getUser()))
            
        ]);
    }

    /**
     * @Route("/jeuxvideo/creation", name="create_article", methods={"GET", "POST"})
     * @Security("is_granted('ROLE_USER')")
     * 
     * I want to create a game, and I want to create a comment for this game. 
     * 
     * I want to create a game, and I want to create a category for this game. 
     * 
     * I want to create a game, and I want to create a comment for this game, and I want to create a
     * category for this game. 
     * 
     * I want to create a game, and I want to create a comment for this game, and I want to create a
     * category for this game, and I want to create a user for this game. 
     * 
     * I want to create a game, and I want to create a comment for this game, and I want to create a
     * category for this game, and I want to create a user for this game, and I want to create a user
     * for this comment. 
     * 
     * I want to create a game, and I want to create a comment
     * 
     * @param Request request The request object.
     * @param EntityManagerInterface entityManager The EntityManagerInterface instance.
     */
    public function createGame(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jeuxvideo = new Jeuxvideo();

        $form = $this->createForm(JeuxvideoType::class, $jeuxvideo);
        $jeuxvideo->setUser($this->getUser());
        foreach($jeuxvideo->getCategories() as $categories){
            $jeuxvideo->setUser($this->getUser());
            $categories->addGame($jeuxvideo);
            $entityManager->persist($categories);
        }
        
        foreach ($jeuxvideo->getComments() as $comments) {
            $jeuxvideo->setUser($this->getUser());
            $comments->setUser($this->getUser());
            $comments->setComment($jeuxvideo);
            $entityManager->persist($comments);
        }
        $form->handleRequest($request);

        
        if ($form->isSubmitted() && $form->isValid()) {
            $jeuxvideo->setUser($this->getUser());
            
            $entityManager->persist($jeuxvideo);
            $entityManager->flush();
            $this->addFlash(
                'success',
                "Le jeux video a bien été crée {$jeuxvideo->getName()}! "
            );
            return $this->redirectToRoute('accueil');
        }
        return $this->render('jeuxvideo/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/jeuxvideo/edition/{slug}", name="edit_article")
     * @Security("is_granted('ROLE_USER') and user === jeuxvideo.getUser()", message="Ce jeux video ne vous appartient pas, vous ne pouvez pas le modifier")
     * 
     * The function editGame() is called when the user clicks on the edit button. It displays the form
     * to edit the game. When the user clicks on the submit button, the function checks if the form is
     * valid. If it is, it persists the changes and flushes them. Then it displays a success message
     * 
     * @param Request request The request object.
     * @param Jeuxvideo jeuxvideo The Jeuxvideo object that will be edited.
     * @param EntityManagerInterface entityManager The EntityManagerInterface is the object that allows
     * you to persist and flush objects to the database.
     * 
     * @return Response The response is the render of the edit.html.twig file.
     */
    public function editGame(Request $request, Jeuxvideo $jeuxvideo, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JeuxvideoType::class, $jeuxvideo);

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $entityManager->persist($jeuxvideo);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Vous avez bien éditer votre jeux : ' . $jeuxvideo->getName() . ' !'
            );
        }

        return $this->render('jeuxvideo/edit.html.twig', [
            'form' => $form->createView(),
            'jeuxvideo' => $jeuxvideo
        ]);
    }

    /**
    * @Route("/jeuxvideo/{slug}", name="article_show")
    * @Security("is_granted('ROLE_USER')")
    * I want to display the game page with the comments form and the comments list
    * 
    * @param JeuxvideoRepository jeuxvideoRepository The repository for the Jeuxvideo entity.
    * @param Request request The request object.
    * @param EntityManagerInterface manager the EntityManagerInterface
    * @param slug The slug of the game to display
    * 
    * @return Response The response of the controller.
    */
    public function displayJeuxvideo(JeuxvideoRepository $jeuxvideoRepository, Request $request, EntityManagerInterface $manager, $slug): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setUser($this->getUser())
                    ->setGame($jeuxvideoRepository->findOneBySlug($slug))
            ;

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre commentaire est enregistré !'
            );
        }
        return $this->render('jeuxvideo/show.html.twig', [
            'jeuxvideo' => $jeuxvideoRepository->findOneBySlug($slug),
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/jeuxvideo/delete/{slug}", name="article_delete")
     * @Security("is_granted('ROLE_USER') and user == jeuxvideo.getUser()", message="Vous n'avez pas le droit d'accéder à ce jeux")
     * 
     * This function deletes a game from the database and redirects to the home page.
     * 
     * @param Jeuxvideo jeuxvideo The object to delete
     * @param EntityManagerInterface entityManager The EntityManagerInterface instance.
     */
    public function delete(Jeuxvideo $jeuxvideo, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($jeuxvideo);
        $entityManager->flush();

        $this->addFlash(
            'success',
            "Le jeux <strong>{$jeuxvideo->getName()}</strong> a bien été supprimée ! "
        );

        return $this->redirectToRoute("accueil");
    }
}
