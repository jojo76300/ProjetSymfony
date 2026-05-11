<?php

namespace App\Controller;

use App\Repository\StageRepository;
use App\Repository\PromotionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/suivi')]
#[IsGranted('ROLE_USER')]
class SuiviController extends AbstractController
{
    #[Route('/', name: 'app_suivi_index', methods: ['GET'])]
    public function index(Request $request, StageRepository $stageRepo, PromotionRepository $promoRepo): Response
    {
        $user = $this->getUser();

        // Récupération des filtres
        $filters = [
            'promotion' => $request->query->get('promotion'),
            'search' => $request->query->get('search'),
        ];

        // On récupère les stages (filtrés par prof si ce n'est pas un admin)
        $stages = $stageRepo->findForSuiviVisites($user, $filters);
        
        $promotions = $promoRepo->findBy([], ['session' => 'DESC', 'classe' => 'ASC']);

        return $this->render('suivi/index.html.twig', [
            'stages' => $stages,
            'promotions' => $promotions,
            'filters' => $filters,
        ]);
    }
}