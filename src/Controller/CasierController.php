<?php

namespace App\Controller;

use App\Entity\Casier;
use App\Form\CreationCasierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CasierController extends AbstractController
{
    #[Route('/casier/new', name: 'casier_new')]
public function create(Request $request, EntityManagerInterface $entityManager): Response
{
    $casier = new Casier();
    $form = $this->createForm(CreationCasierType::class, $casier);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $nombreCasiers = $casier->getNombreCasiers(); // Récupère le nombre de casiers à créer
        $entrepot = $form->get('entrepot')->getData();

        for ($i = 0; $i < $nombreCasiers; $i++) {
            $newCasier = new Casier();
            $newCasier->setEntrepot($entrepot); // Associer l'entrepôt
            // Vous pouvez ajouter d'autres propriétés si nécessaire
            $entityManager->persist($newCasier);
        }

        $entityManager->flush();

        return $this->redirectToRoute('casier_list'); // Redirection vers la liste des casiers
    }

    return $this->render('casier/new.html.twig', [
        'form' => $form->createView(),
    ]);
}


    #[Route('/casiers', name: 'casier_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $casiers = $entityManager->getRepository(Casier::class)->findAll();

        return $this->render('casier/list.html.twig', [
            'casiers' => $casiers,
        ]);
    }
}


