<?php

namespace App\Controller;

use App\Entity\Distance;
use App\Form\DefinitionDistanceType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DistanceController extends AbstractController
{
    #[Route('/distance/new', name: 'distance_new')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $distance = new Distance();
        $form = $this->createForm(DefinitionDistanceType::class, $distance);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Assigner les relations
            $distance->setVille($form->get('ville')->getData());
            $distance->setEntrepot($form->get('entrepot')->getData());

            // Enregistre la distance
            $entityManager->persist($distance);
            $entityManager->flush();

            return $this->redirectToRoute('distance_list'); // Redirection vers la liste des distances
        }

        return $this->render('distance/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/distance', name: 'distance_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Récupère toutes les distances
        $distances = $entityManager->getRepository(Distance::class)->findAll();

        return $this->render('distance/list.html.twig', [
            'distances' => $distances,
        ]);
    }
}

