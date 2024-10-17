<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Form\VilleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VilleController extends AbstractController
{
    #[Route('/creer-ville', name: 'creer_ville')]
    public function creerVille(Request $request, EntityManagerInterface $em): Response
    {
        // 1. Créer une instance de l'entité Ville
        $ville = new Ville();

        // 2. Créer le formulaire lié à cette entité
        $form = $this->createForm(VilleType::class, $ville);

        // 3. Gérer la soumission de la requête
        $form->handleRequest($request);

        // 4. Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // 5. Si le formulaire est valide, enregistrer les données en base de données
            $em->persist($ville);
            $em->flush();

            // 6. Rediriger vers une autre page ou afficher un message de confirmation
            return $this->redirectToRoute('resultat_ville', [
                'id' => $ville->getId(),
            ]);
        }

        // 7. Afficher le formulaire dans la vue
        return $this->render('ville/creer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    
}