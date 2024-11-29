<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

// Include paginator interface
use Knp\Component\Pager\PaginatorInterface;


class DefaultController extends AbstractController
{

    #[Route('/', name: 'homepage')]
    public function index(Request $request, EntityManagerInterface $em,  PaginatorInterface $paginator): Response
    {   

        // Get from database
        $posts = $em->createQueryBuilder()
        ->select('P')
        ->from(Post::class, 'P')
        ->getQuery()
        ->getResult();
     
        // Use paginator
        $pagination = $paginator->paginate($posts,$request->query->getInt('page', 1),10);


        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'posts' => $pagination
        ]);
    }

    #[Route("/atrykul/{id}", name: "post_show" )]
    public function show(Post $post,EntityManagerInterface $em, Request $request) {

        //Create new comment object
        $comment = new Comment();
        //Add comment to post
        $comment->setPost($post);

        //Add comment to user
        //$comment->setUser($user)

        // Create comment form
        $form = $this->createForm(CommentType::class, $comment);


        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            $this->addFlash('success', "Komentarz został dodany.");

            return $this->redirectToRoute('post_show', ['id' => $post->getId()]);
        }

        return $this->render('default/show.html.twig', [
            'post' => $post,
            'form' => $form->createView()
        ]);
    }


}
