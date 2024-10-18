<?php
// src/Controller/ColisController.php
namespace App\Controller;

use App\Entity\Colis;
use App\Form\ColisType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ColisController extends AbstractController
{
    #[Route('/colis/creer', name: 'creer_colis')]
    public function creerColis(Request $request, EntityManagerInterface $em): Response
    {
        $ville = $this->getDoctrine()->getRepository(Ville::class)->find($villeId);

        if (!$ville) {
            throw $this->createNotFoundException('Ville non trouvée.');
        }

        // Récupérer toutes les distances (ou une instance spécifique)
        $distanceEntity = new Distance(); // ou récupérer via EntityManager

        // Récupérer l'entrepôt avec la distance minimale pour la ville spécifiée
        $entrepot = $distanceEntity->getMinDistanceEntrepot($ville);

        // 1. Créer une instance de l'entité Colis
        $colis = new Colis();

        // 2. Créer le formulaire lié à cette entité
        $form = $this->createForm(ColisType::class, $colis);

        // 3. Gérer la soumission de la requête
        $form->handleRequest($request);

        // 4. Vérifier si le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            // 5. Si le formulaire est valide, enregistrer les données en base de données
            $em->persist($colis);
            $em->flush();

            // Redirection vers le formulaire lui-même ou une autre page
            return $this->redirectToRoute('creer_colis');
        }

        // 6. Afficher le formulaire dans la vue
        return $this->render('colis/creer.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/colis/creer', name: 'creer_colis')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les casiers
        $colis = $entityManager->getRepository(Colis::class)->findAll();

        return $this->render('colis/list.html.twig', [
            'colis' => $colis,
        ]);
    }
}
