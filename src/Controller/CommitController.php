<?php

namespace App\Controller;

use App\Entity\Commit;
use App\Form\Commit1Type;
use App\Repository\CommitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/commit")
 */
class CommitController extends AbstractController
{
    /**
     * @Route("/", name="commit_index", methods={"GET"})
     */
    public function index(CommitRepository $commitRepository): Response
    {
        return $this->render('commit/index.html.twig', [
            'commits' => $commitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="commit_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $commit = new Commit();
        $form = $this->createForm(Commit1Type::class, $commit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commit);
            $entityManager->flush();

            return $this->redirectToRoute('commit_index');
        }

        return $this->render('commit/new.html.twig', [
            'commit' => $commit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commit_show", methods={"GET"})
     */
    public function show(Commit $commit): Response
    {
        return $this->render('commit/show.html.twig', [
            'commit' => $commit,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Commit $commit): Response
    {
        $form = $this->createForm(Commit1Type::class, $commit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commit_index');
        }

        return $this->render('commit/edit.html.twig', [
            'commit' => $commit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commit_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Commit $commit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$commit->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($commit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commit_index');
    }
}
