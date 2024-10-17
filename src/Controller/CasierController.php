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
        $casier = new Casier();
        $form = $this->createForm(CreationCasierType::class, $casier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupère le nombre de casiers à créer depuis le formulaire (non mappé)
            $entrepotNbCasier = $form->get('nbCasiers')->getData(); 
            
            // Récupère l'entrepôt sélectionné depuis le formulaire
            $lentrepot = $form->get('lentrepot')->getData();

            // Crée le nombre de casiers défini dans le formulaire
            for ($i = 0; $i < $entrepotNbCasier; $i++) {
                $newCasier = new Casier();
                $newCasier->setLEntrepot($lentrepot); // Associer l'entrepôt
                $newCasier->setStatus(true); // Set other attributes as needed
                
                // Crée 9 compartiments pour chaque casier
                for ($j = 0; $j < 9; $j++) {
                    $compartiment = new Compartiment();
                    $compartiment->setStatus(false); // Status par défaut
                    $newCasier->addLesCompartiment($compartiment); // Ajout du compartiment
                }

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


