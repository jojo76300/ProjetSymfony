<?php
namespace App\Controller;

use App\Repository\EtudiantRepository;
use App\Repository\StageRepository;
use App\Repository\EntrepriseRepository;
use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function home(
        EtudiantRepository $etuRepo,
        StageRepository $stageRepo,
        EntrepriseRepository $entRepo,
        VisiteRepository $visiteRepo
    ): Response {
        // 1. Redirection si non connecté
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // 2. Calcul des statistiques de base (KPIs)
        $totalEtudiants = $etuRepo->count([]);
        
        // Utilisation des requêtes optimisées du Repository
        $etudiantsSlam = $etuRepo->countByFiliere('SLAM');
        $etudiantsSisr = $etuRepo->countByFiliere('SISR');
        
        $totalStagesEnCours = $stageRepo->count(['statutAttestation' => 'En cours']);
        $totalEntreprises = $entRepo->count([]);
        
        // Calcul simple des visites à planifier
        $totalStages = $stageRepo->count([]);
        $totalVisites = $visiteRepo->count([]);
        $visitesAPlanifier = max(0, $totalStages - $totalVisites);

        // 3. Gestion des alertes
        $alertes = [];
        $stagesSansProf = $stageRepo->findBy(['profSuivi' => null]);
        if (count($stagesSansProf) > 0) {
            $alertes[] = [
                'type' => 'warning',
                'message' => count($stagesSansProf) . ' dossiers de stage n\'ont pas de professeur de suivi assigné.'
            ];
        }

        // 4. Prochaines visites (FILTRÉES SELON LE RÔLE)
        if ($this->isGranted('ROLE_ADMIN')) {
            // L'ADMIN voit toutes les prochaines visites
            $prochainesVisites = $visiteRepo->findBy(
                [], // Aucun critère
                ['dateVisite' => 'ASC'], // Tri croissant par date
                5 // Limite à 5
            );
        } else {
            // LE PROFESSEUR ne voit que SES visites
            // Assure-toi que la propriété s'appelle bien 'enseignantVisiteur' dans ton entité Visite
            $prochainesVisites = $visiteRepo->findBy(
                ['enseignantVisiteur' => $user], // Le filtre !
                ['dateVisite' => 'ASC'], 
                5 
            );
        }

        // 5. Affichage de la vue
        return $this->render('dashboard/home.html.twig', [
            'stats' => [
                'etudiants_total' => $totalEtudiants,
                'etudiants_slam' => $etudiantsSlam,
                'etudiants_sisr' => $etudiantsSisr,
                'stages_en_cours' => $totalStagesEnCours,
                'entreprises' => $totalEntreprises,
                'visites_a_planifier' => $visitesAPlanifier
            ],
            'alertes' => $alertes,
            'prochaines_visites' => $prochainesVisites
        ]);
    }
}