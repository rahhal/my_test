<?php

namespace App\Controller;

use App\Entity\Neighborhood;
use App\Form\NeighborhoodType;
use App\Repository\NeighborhoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/neighborhood")
 */
class NeighborhoodController extends AbstractController
{
    /**
     * @Route("/", name="neighborhood_index", methods={"GET"})
     */
    public function index(NeighborhoodRepository $neighborhoodRepository): Response
    {
        return $this->render('neighborhood/index.html.twig', [
            'neighborhoods' => $neighborhoodRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="neighborhood_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $neighborhood = new Neighborhood();
        $form = $this->createForm(NeighborhoodType::class, $neighborhood);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($neighborhood);
            $entityManager->flush();

            return $this->redirectToRoute('neighborhood_index');
        }

        return $this->render('neighborhood/new.html.twig', [
            'neighborhood' => $neighborhood,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="neighborhood_show", methods={"GET"})
     */
    public function show(Neighborhood $neighborhood): Response
    {
        return $this->render('neighborhood/show.html.twig', [
            'neighborhood' => $neighborhood,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="neighborhood_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Neighborhood $neighborhood): Response
    {
        $form = $this->createForm(NeighborhoodType::class, $neighborhood);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('neighborhood_index');
        }

        return $this->render('neighborhood/edit.html.twig', [
            'neighborhood' => $neighborhood,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="neighborhood_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Neighborhood $neighborhood): Response
    {
        if ($this->isCsrfTokenValid('delete'.$neighborhood->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($neighborhood);
            $entityManager->flush();
        }

        return $this->redirectToRoute('neighborhood_index');
    }
}
