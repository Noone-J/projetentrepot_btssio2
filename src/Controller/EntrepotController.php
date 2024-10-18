<?php

namespace App\Controller;

use App\Entity\Entrepot;
use App\Form\CreationEntrepotsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EntrepotController extends AbstractController
{
    #[Route('/entrepot/creer', name: 'entrepot_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Créer une nouvelle instance d'Entrepot
        $entrepot = new Entrepot();

        // Créer le formulaire en utilisant le type de formulaire personnalisé
        $form = $this->createForm(CreationEntrepotsType::class, $entrepot);

        // Gérer la requête HTTP avec le formulaire
        $form->handleRequest($request);

        // Vérifier si le formulaire a été soumis et validé
        if ($form->isSubmitted() && $form->isValid()) {
            // Persister et sauvegarder les données en base de données
            $entityManager->persist($entrepot);
            $entityManager->flush();

            // Rediriger l'utilisateur vers une autre page (par exemple, la liste des entrepôts)
            return $this->redirectToRoute('entrepot_list');
        }

        // Afficher la vue du formulaire si la requête n'est pas un POST ou si le formulaire n'est pas encore soumis
        return $this->render('entrepot/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/entrepot', name: 'entrepot_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Récupérer la liste des entrepôts pour les afficher
        $entrepots = $entityManager->getRepository(Entrepot::class)->findAll();

        return $this->render('entrepot/list.html.twig', [
            'entrepots' => $entrepots,
        ]);
    }
}
