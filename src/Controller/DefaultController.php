<?php

namespace App\Controller;


use App\Entity\Blogpost;
use App\Entity\Commit;
use App\Form\BlogpostType;
use App\Form\CommitType;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        $em = $this->getDoctrine()->getRepository(Blogpost::class);




        return $this->render('default/index.html.twig', [
            'articles' => $em->findAll(),
        ]);
    }


    /**
     * @Route("/article/{id}", name="article")
     */
    public function article($id, Request $request): Response
    {
        $emCommit = $this->getDoctrine()->getRepository(Commit::class);

        $emBlogpost = $this->getDoctrine()->getRepository(Blogpost::class);
        $article = $emBlogpost->find($id);

        $commit = new Commit;
        $form = $this->createForm(CommitType::class, $commit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $commit = $form->getData();
            $commit->setDateOfCreation(new DateTime());
            $commit->setArticle($emBlogpost->find($id));

            $em = $this->getDoctrine()->getManager();
            $em->persist($commit);
            $em->flush();
        }


        return $this->render('default/article.html.twig', [
            "article" =>  $article,
            'form' => $form->createView(),
            "commits" => $emCommit->FindBy(['article' => $article], ['date_of_creation' => 'ASC'], 30)

        ]);
    }

    /**
     * @Route("/newarticle", name="newArticle")
     */
    public function addArticle(Request $request): Response
    {
        $blogpost = new Blogpost;
        $form = $this->createForm(BlogpostType::class, $blogpost);


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $blogpost = $form->getData();
            $blogpost->setDateOfPublication(new DateTime());
            $blogpost->setAuthor($this->getUser());


            $em = $this->getDoctrine()->getManager();
            $em->persist($blogpost);
            $em->flush();

            return $this->redirectToRoute('/');
        }


        return $this->render('default/formrender.html.twig', [
            'form' => $form->createView()
        ]);
    }
}