<?php

namespace App\Controller;

use App\Entity\Casier;
use App\Entity\Entrepot;
use App\Entity\Compartiment;
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
        // Créer une nouvelle instance de Casier
        $casier = new Casier();

        // Créer le formulaire
        $form = $this->createForm(CreationCasierType::class, $casier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le nombre de casiers à créer depuis le formulaire
            $entrepotNbCasier = $form->get('nbCasiers')->getData(); 

            // Récupérer l'entrepôt sélectionné depuis le formulaire
            $lentrepot = $form->get('lentrepot')->getData();

            // Créer les casiers
            for ($i = 0; $i < $entrepotNbCasier; $i++) {
                $newCasier = new Casier();
                $newCasier->setLEntrepot($lentrepot); // Associer l'entrepôt
                $newCasier->setStatus(true); // Statut par défaut (ajustable)
                $newCasier->setTaille(100);

                // Créer 9 compartiments pour chaque casier
                for ($j = 0; $j < 9; $j++) {
                    $compartiment = new Compartiment();
                    $compartiment->setStatus(false); // Statut par défaut
                    
                    // Associer le compartiment au casier
                    $newCasier->addLesCompartiment($compartiment);

                    // Persister le compartiment
                    $entityManager->persist($compartiment);
                }

                // Persister le nouveau casier après avoir persisté les compartiments
                $entityManager->persist($newCasier);
            }

            // Sauvegarder les casiers créés et l'entrepôt mis à jour dans la base de données
            $entityManager->flush();

            return $this->redirectToRoute('casier_list');
        }

        return $this->render('casier/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/casiers', name: 'casier_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les casiers
        $casiers = $entityManager->getRepository(Casier::class)->findAll();

        return $this->render('casier/list.html.twig', [
            'casiers' => $casiers,
        ]);
    }
}


