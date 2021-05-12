<?php

namespace App\Controller;

use App\Entity\Personnes;
use App\Form\PersonnesType;
use App\Repository\PersonnesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/personnes")
 */
class PersonnesController extends AbstractController
{
    /**
     * @Route("/", name="personnes_index", methods={"GET"})
     */
    public function index(PersonnesRepository $personnesRepository): Response
    {


        return $this->render('personnes/index.html.twig', [
            'personnes' => $personnesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="personnes_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $personne = new Personnes();
        $form = $this->createForm(PersonnesType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($personne);
            $entityManager->flush();

            return $this->redirectToRoute('personnes_index');
        }

        return $this->render('personnes/new.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="personnes_show", methods={"GET"})
     */
    public function show(Personnes $personne): Response
    {
        return $this->render('personnes/show.html.twig', [
            'personne' => $personne,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="personnes_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Personnes $personne): Response
    {
        $form = $this->createForm(PersonnesType::class, $personne);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('personnes_index');
        }

        return $this->render('personnes/edit.html.twig', [
            'personne' => $personne,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="personnes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Personnes $personne): Response
    {
        if ($this->isCsrfTokenValid('delete'.$personne->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($personne);
            $entityManager->flush();
        }

        return $this->redirectToRoute('personnes_index');
    }
}
