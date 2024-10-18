<?php

namespace App\Controller;

use App\Entity\Colis;
use App\Entity\Entrepot;
use App\Entity\Casier;
use App\Entity\Compartiment;
use App\Entity\Ville;
use App\Form\ColisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class ColisController extends AbstractController
{
    #[Route('/colis/creer', name: 'creer_colis')]
    public function creerColis(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les distances (ou une instance spécifique)
        $distanceEntity = new \App\Entity\Distance();


        $entrepots = $entityManager->getRepository(Entrepot::class)->findAll();
        // Récupérer l'entrepôt avec la distance minimale pour la ville spécifiée
        $ville = $entityManager->getRepository(Ville::class)->findOneBy(['nom' => 'Lannion']); 
        $entrepotMin = null;
        $minDistance = null;
        foreach ($entrepots as $entrepot) {
            $distance = $entrepot->getMinDistanceEntrepot($ville);
            if ($distance !== null) {
                if ($minDistance === null || $distance < $minDistance) {
                    $minDistance = $distance;
                    $entrepotMin = $entrepot;
                }
            }
        }

        // 1. Créer une instance de l'entité Colis
        $colis = new Colis();

        // 2. Créer le formulaire lié à cette entité
        $form = $this->createForm(ColisType::class, $colis);

        // 3. Gérer la soumission de la requête
        $form->handleRequest($request);

        // 4. Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // Trouver un entrepôt disponible
            $entrepotDisponible = null;
            foreach ($entityManager->getRepository(Entrepot::class)->findAll() as $entrepot) {
                if (!$entrepot->verifStatusEntrepot()) {
                    $entrepotDisponible = $entrepot;
                    break;
                }
            }

            if ($entrepotDisponible) {
                // Trouver un casier disponible dans cet entrepôt
                $casierDisponible = null;
                foreach ($entrepotDisponible->getLesCasiers() as $casier) {
                    if (!$casier->verifStatusCasier()) {
                        $casierDisponible = $casier;
                        break;
                    }
                }

                if ($casierDisponible) {
                    // Trouver un compartiment disponible dans ce casier
                    $compartimentDisponible = null;
                    foreach ($casierDisponible->getLesCompartiments() as $compartiment) {
                        if (!$compartiment->verifStatusCompartiment()) {
                            $compartimentDisponible = $compartiment;
                            break;
                        }
                    }

                    if ($compartimentDisponible) {
                        // Ajouter le colis au compartiment
                        $colis->setLaVille($ville); // Associer la ville
                        $compartimentDisponible->setLeColis($colis);
                        $compartimentDisponible->setStatus(true); // Marquer le compartiment comme occupé

                        // Enregistrer les modifications
                        $entityManager->persist($colis);
                        $entityManager->flush();

                        $this->addFlash('success', 'Le colis a été créé et placé dans un compartiment.');
                        return $this->redirectToRoute('liste_colis');
                    } else {
                        $this->addFlash('error', 'Désolé, aucun compartiment disponible trouvé dans ce casier.');
                    }
                } else {
                    $this->addFlash('error', 'Désolé, aucun casier disponible trouvé dans cet entrepôt.');
                }
            } else {
                $this->addFlash('error', 'Désolé, aucun entrepôt disponible trouvé.');
            }
        }

        // 6. Afficher le formulaire dans la vue
        return $this->render('colis/creer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/colis/liste', name: 'liste_colis')]
    public function liste(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les colis
        $colis = $entityManager->getRepository(Colis::class)->findAll();

        return $this->render('colis/list.html.twig', [
            'colis' => $colis,
        ]);
    }
}